<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ShiftHistoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $search    = $request->get('search');
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate   = $request->get('end_date', Carbon::today()->addDays(30)->format('Y-m-d'));
        $status    = $request->get('status');

        // Base query for all employees
        $query = Employee::with(['shifts' => function ($query) use ($startDate, $endDate, $status) {
            $query->whereBetween('shift_date', [$startDate, $endDate])
                ->orderBy('shift_date', 'asc');
            if ($status) {
                $query->where('status', $status);
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
                    'status'      => $shift->status,
                    'created_at'  => $employee->created_at,
                ]);
            }
        }

        $shiftRows = $shiftRows->sortBy([
            ['shift_date', 'asc'],
            ['name', 'asc'],
        ]);

        $page      = $request->get('page', 1);
        $shiftRows = new \Illuminate\Pagination\LengthAwarePaginator(
            $shiftRows->forPage($page, $perPage),
            $shiftRows->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('ShiftHistory', compact(
            'shiftRows',
            'perPageOptions',
            'perPage',
            'search',
            'startDate',
            'endDate',
            'status'
        ));
    }
}
