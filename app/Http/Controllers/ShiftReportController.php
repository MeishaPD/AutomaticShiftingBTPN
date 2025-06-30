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

        $startYear = Carbon::parse($startDate)->year;
        $endYear = Carbon::parse($endDate)->year;

        $query = Employee::with([
            'shifts' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('shift_date', [$startDate, $endDate]);
            },
            'leaves' => function ($query) use ($startYear, $endYear) {
                $query->where(function ($q) use ($startYear, $endYear) {
                    $yearStart = Carbon::create($startYear, 1, 1)->format('Y-m-d');
                    $yearEnd = Carbon::create($endYear, 12, 31)->format('Y-m-d');
                    
                    $q->where(function ($dateQuery) use ($yearStart, $yearEnd) {
                        $dateQuery->whereBetween('leave_start', [$yearStart, $yearEnd])
                                 ->orWhereBetween('leave_end', [$yearStart, $yearEnd])
                                 ->orWhere(function ($spanQuery) use ($yearStart, $yearEnd) {
                                     $spanQuery->where('leave_start', '<=', $yearStart)
                                              ->where('leave_end', '>=', $yearEnd);
                                 });
                    });
                });
            }
        ]);

        if ($nik) {
            $query->where('nik', 'like', "%{$nik}%");
        }

        $employees = $query->get();

        $shiftRows = new Collection();

        foreach ($employees as $employee) {
            $wfhCount    = $employee->shifts->where('type', 'WFH')->count();
            $wfoCount    = $employee->shifts->where('type', 'WFO')->count();
            $totalShifts = $wfhCount + $wfoCount;

            $totalYearlyLeaveDays = 0;
            $totalSpecialLeaveDays = 0;

            foreach ($employee->leaves as $leave) {
                $leaveStart = Carbon::parse($leave->leave_start);
                $leaveEnd = Carbon::parse($leave->leave_end);
                
                $yearStart = Carbon::create($startYear, 1, 1);
                $yearEnd = Carbon::create($endYear, 12, 31);
                
                $overlapStart = $leaveStart->max($yearStart);
                $overlapEnd = $leaveEnd->min($yearEnd);
                
                if ($overlapStart <= $overlapEnd) {
                    $leaveDuration = $overlapStart->diffInDays($overlapEnd) + 1;
                    
                    $leaveType = is_object($leave->type) ? $leave->type->value : $leave->type;
                    
                    if ($leaveType === 'yearly') {
                        $totalYearlyLeaveDays += $leaveDuration;
                    } elseif ($leaveType === 'special') {
                        $totalSpecialLeaveDays += $leaveDuration;
                    }
                }
            }

            if (! $onlyWithShifts || $totalShifts > 0) {
                $shiftRows->push([
                    'employee_id'         => $employee->id,
                    'nik'                 => $employee->nik,
                    'name'                => $employee->name,
                    'gender'              => $employee->gender,
                    'location'            => $employee->location,
                    'total_wfh'           => $wfhCount,
                    'total_wfo'           => $wfoCount,
                    'total_yearly_leave'  => $totalYearlyLeaveDays,
                    'total_special_leave' => $totalSpecialLeaveDays,
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