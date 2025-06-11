<?php
namespace App\Services;

use App\Enums\ShiftType;
use App\Models\Employee;
use App\Models\EmployeeShift;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ShiftGeneratorService
{
    public function generateShiftsForNextMonth(): void
    {
        $targetDate = Carbon::today()->addMonth();

        if ($targetDate->isWeekend()) {
            return;
        }

        $onboardingEmployees = Employee::where('is_onboarding', true)->get();

        $this->assignShiftsForDate($targetDate->format('Y-m-d'), $onboardingEmployees);
    }

    private function assignShiftsForDate(string $date, Collection $employees): void
    {
        $currentShifts = EmployeeShift::where('shift_date', $date)->get();
        $wfoCount      = $currentShifts->where('type', ShiftType::WFO)->count();
        $wfhCount      = $currentShifts->where('type', ShiftType::WFH)->count();

        // If quota is already met, skip this date
        if ($wfoCount >= 3 && $wfhCount >= 2) {
            return;
        }

        // Get employees who don't have a shift for this date
        $availableEmployees = $employees->filter(function ($employee) use ($date) {
            return ! EmployeeShift::where('employee_id', $employee->id)
                ->where('shift_date', $date)
                ->exists();
        })->shuffle();

        foreach ($availableEmployees as $employee) {
            // Determine shift type based on current counts
            $shiftType = null;
            if ($wfoCount < 2 && $wfhCount < 3) {
                $shiftType = rand(0, 1) ? ShiftType::WFO : ShiftType::WFH;
            } elseif ($wfoCount < 2) {
                $shiftType = ShiftType::WFO;
            } elseif ($wfhCount < 3) {
                $shiftType = ShiftType::WFH;
            } else {
                break;
            }

            EmployeeShift::create([
                'employee_id' => $employee->id,
                'type'        => $shiftType,
                'shift_date'  => $date,
            ]);

            if ($shiftType === ShiftType::WFO) {
                $wfoCount++;
            } else {
                $wfhCount++;
            }

            if ($wfoCount >= 2 && $wfhCount >= 3) {
                break;
            }
        }
    }
}
