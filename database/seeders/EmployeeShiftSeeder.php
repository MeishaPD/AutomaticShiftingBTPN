<?php
namespace Database\Seeders;

use App\Enums\ShiftType;
use App\Models\Employee;
use App\Models\EmployeeShift;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee_shifts')->truncate();

        $onboardingEmployees = Employee::where('is_onboarding', true)->get();
        $startDate           = Carbon::today();
        $endDate             = Carbon::today()->addDays(30);

        $dates       = collect();
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            if (! $currentDate->isWeekend()) {
                $dates->push($currentDate->format('Y-m-d'));
            }
            $currentDate->addDay();
        }

        foreach ($dates as $date) {
            $availableEmployees = $onboardingEmployees->shuffle();
            $wfoCount           = 0;
            $wfhCount           = 0;

            foreach ($availableEmployees as $employee) {
                if (EmployeeShift::where('employee_id', $employee->id)
                    ->where('shift_date', $date)
                    ->exists()) {
                    continue;
                }

                // Determine shift type based on current counts
                $shiftType = null;
                if ($wfoCount < 3 && $wfhCount < 2) {
                    $shiftType = rand(0, 1) ? ShiftType::WFO : ShiftType::WFH;
                } elseif ($wfoCount < 3) {
                    $shiftType = ShiftType::WFO;
                } elseif ($wfhCount < 2) {
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
}
