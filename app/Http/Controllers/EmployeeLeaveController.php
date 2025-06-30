<?php
namespace App\Http\Controllers;

class EmployeeLeaveController extends Controller
{
    // public function index(Request $request)
    // {
    //     $perPage        = $request->get('per_page', 10);
    //     $perPageOptions = [10, 25, 50, 100];

    //     $search    = $request->get('search');
    //     $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
    //     $endDate   = $request->get('end_date', Carbon::today()->addDays(30)->format('Y-m-d'));
    //     $shiftType = $request->get('shift_type');

    //     // Base query for onboarding employees
    //     $query = Employee::where('is_onboarding', true)
    //         ->with(['shifts' => function ($query) use ($startDate, $endDate, $shiftType) {
    //             $query->whereBetween('shift_date', [$startDate, $endDate])
    //                 ->where('status', ShiftStatus::APROVED)
    //                 ->orderBy('shift_date', 'asc');
    //             if ($shiftType) {
    //                 $query->where('type', $shiftType);
    //             }
    //         }]);

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('nik', 'like', "%{$search}%")
    //                 ->orWhere('name', 'like', "%{$search}%");
    //         });
    //     }

    //     $employees = $query->orderBy('created_at', 'desc')->get();

    //     $shiftRows = new Collection();

    //     foreach ($employees as $employee) {
    //         foreach ($employee->shifts as $shift) {
    //             $shiftRows->push([
    //                 'employee_id' => $employee->id,
    //                 'nik'         => $employee->nik,
    //                 'name'        => $employee->name,
    //                 'gender'      => $employee->gender,
    //                 'location'    => $employee->location,
    //                 'shift_date'  => $shift->shift_date,
    //                 'shift_type'  => $shift->type,
    //                 'created_at'  => $employee->created_at,
    //             ]);
    //         }
    //     }

    //     $shiftRows = $shiftRows->sortBy([
    //         ['shift_date', 'asc'],
    //         ['name', 'asc'],
    //     ]);

    //     $page      = $request->get('page', 1);
    //     $perPage   = $request->get('per_page', 10);
    //     $shiftRows = new \Illuminate\Pagination\LengthAwarePaginator(
    //         $shiftRows->forPage($page, $perPage),
    //         $shiftRows->count(),
    //         $perPage,
    //         $page,
    //         ['path' => $request->url(), 'query' => $request->query()]
    //     );

    //     return view('employee-onboarding.index', compact(
    //         'shiftRows',
    //         'perPageOptions',
    //         'perPage',
    //         'search',
    //         'startDate',
    //         'endDate',
    //         'shiftType'
    //     ));
    // }

    public function create()
    {
        return view('leave-onboarding.index');
    }
}
