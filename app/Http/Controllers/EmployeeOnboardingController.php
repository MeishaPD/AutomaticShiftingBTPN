<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeOnboardingController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $employees = Employee::where('is_onboarding', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('employee-onboarding.index', compact('employees', 'perPageOptions', 'perPage'));
    }

    public function create()
    {
        return view('employee-onboarding.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|exists:employees,nik',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size'     => 'NIK harus tepat 16 digit',
            'nik.exists'   => 'Karyawan dengan NIK tersebut tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee = Employee::where('nik', $request->nik)->first();

        if ($employee->is_onboarding) {
            return redirect()->back()
                ->withErrors(['nik' => 'Karyawan ini sudah dalam status onboarding'])
                ->withInput();
        }

        $employee->update(['is_onboarding' => true]);

        return redirect()->route('employee.onboarding')
            ->with('success', 'Karyawan berhasil ditambahkan ke onboarding');
    }

    public function delete()
    {
        return view('employee-onboarding.delete');
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|exists:employees,nik',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size'     => 'NIK harus tepat 16 digit',
            'nik.exists'   => 'Karyawan dengan NIK tersebut tidak ditemukan',
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

        $employee->update(['is_onboarding' => false]);

        return redirect()->route('employee.onboarding')
            ->with('success', 'Karyawan berhasil dihapus dari onboarding');
    }
}
