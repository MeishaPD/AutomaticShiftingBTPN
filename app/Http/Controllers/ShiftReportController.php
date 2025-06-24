<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ShiftReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $nik            = $request->get('nik');
        $startDate      = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate        = $request->get('end_date', Carbon::today()->addDays(30)->format('Y-m-d'));
        $onlyWithShifts = $request->boolean('only_with_shifts');

        $query = Employee::with(['shifts' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('shift_date', [$startDate, $endDate]);
        }]);

        if ($nik) {
            $query->where('nik', 'like', "%{$nik}%");
        }

        $employees = $query->get();

        $shiftRows = new Collection();

        foreach ($employees as $employee) {
            $wfhCount    = $employee->shifts->where('type', 'WFH')->count();
            $wfoCount    = $employee->shifts->where('type', 'WFO')->count();
            $totalShifts = $wfhCount + $wfoCount;

            if (! $onlyWithShifts || $totalShifts > 0) {
                $shiftRows->push([
                    'employee_id' => $employee->id,
                    'nik'         => $employee->nik,
                    'name'        => $employee->name,
                    'gender'      => $employee->gender,
                    'location'    => $employee->location,
                    'total_wfh'   => $wfhCount,
                    'total_wfo'   => $wfoCount,
                ]);
            }
        }

        $shiftRows = $shiftRows->sortBy('name');

        $page      = $request->get('page', 1);
        $shiftRows = new \Illuminate\Pagination\LengthAwarePaginator(
            $shiftRows->forPage($page, $perPage),
            $shiftRows->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('ShiftReport', [
            'shiftRows'      => $shiftRows,
            'perPageOptions' => $perPageOptions,
            'perPage'        => $perPage,
            'nik'            => $nik,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'onlyWithShifts' => $onlyWithShifts,
        ]);
    }
}
