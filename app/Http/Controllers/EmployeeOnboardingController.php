<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeShift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class EmployeeOnboardingController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $search    = $request->get('search');
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate   = $request->get('end_date', Carbon::today()->addDays(30)->format('Y-m-d'));
        $shiftType = $request->get('shift_type');

        // Base query for onboarding employees
        $query = Employee::where('is_onboarding', true)
            ->with(['shifts' => function ($query) use ($startDate, $endDate, $shiftType) {
                $query->whereBetween('shift_date', [$startDate, $endDate])
                    ->orderBy('shift_date', 'asc');
                if ($shiftType) {
                    $query->where('type', $shiftType);
                }
            }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('created_at', 'desc')->get();

        $shiftRows = new Collection();

        foreach ($employees as $employee) {
            foreach ($employee->shifts as $shift) {
                $shiftRows->push([
                    'employee_id' => $employee->id,
                    'nik'         => $employee->nik,
                    'name'        => $employee->name,
                    'gender'      => $employee->gender,
                    'location'    => $employee->location,
                    'shift_date'  => $shift->shift_date,
                    'shift_type'  => $shift->type,
                    'created_at'  => $employee->created_at,
                ]);
            }
        }

        $shiftRows = $shiftRows->sortBy([
            ['shift_date', 'asc'],
            ['name', 'asc'],
        ]);

        $page      = $request->get('page', 1);
        $perPage   = $request->get('per_page', 10);
        $shiftRows = new \Illuminate\Pagination\LengthAwarePaginator(
            $shiftRows->forPage($page, $perPage),
            $shiftRows->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('employee-onboarding.index', compact(
            'shiftRows',
            'perPageOptions',
            'perPage',
            'search',
            'startDate',
            'endDate',
            'shiftType'
        ));
    }

    public function delete()
    {
        return view('employee-onboarding.delete');
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'        => 'required|string|size:16|exists:employees,nik',
            'shift_date' => 'required|date|after_or_equal:today',
        ], [
            'nik.required'              => 'NIK wajib diisi',
            'nik.size'                  => 'NIK harus tepat 16 digit',
            'nik.exists'                => 'Karyawan dengan NIK tersebut tidak ditemukan',
            'shift_date.required'       => 'Tanggal shift wajib diisi',
            'shift_date.date'           => 'Format tanggal tidak valid',
            'shift_date.after_or_equal' => 'Tanggal shift harus hari ini atau setelahnya',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee = Employee::where('nik', $request->nik)->first();

        if (! $employee->is_onboarding) {
            return redirect()->back()
                ->withErrors(['nik' => 'Karyawan ini tidak dalam status onboarding'])
                ->withInput();
        }

        $deleted = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', $request->shift_date)
            ->delete();

        if (! $deleted) {
            return redirect()->back()
                ->withErrors(['shift_date' => 'Tidak ada shift yang ditemukan untuk tanggal tersebut'])
                ->withInput();
        }

        return redirect()->route('employee.onboarding')
            ->with('success', 'Shift karyawan berhasil dihapus');
    }
}
