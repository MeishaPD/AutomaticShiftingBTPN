<?php
namespace App\Exports;

use App\Enums\ShiftType;
use App\Models\EmployeeShift;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class AllShiftsExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function sheets(): array
    {
        return [
            new class($this->startDate, $this->endDate) extends BaseShiftExport implements WithTitle
        {
                public function collection()
            {
                    return EmployeeShift::with('employee')
                        ->whereBetween('shift_date', [$this->startDate, $this->endDate])
                        ->orderBy('shift_date')
                        ->get();
                }

                public function title(): string
            {
                    return 'Semua Shift';
                }
            },
            new class($this->startDate, $this->endDate) extends BaseShiftExport implements WithTitle
        {
                public function collection()
            {
                    return EmployeeShift::with('employee')
                        ->whereBetween('shift_date', [$this->startDate, $this->endDate])
                        ->where('type', ShiftType::WFO)
                        ->orderBy('shift_date')
                        ->get();
                }

                public function title(): string
            {
                    return 'WFO Shift';
                }
            },
            new class($this->startDate, $this->endDate) extends BaseShiftExport implements WithTitle
        {
                public function collection()
            {
                    return EmployeeShift::with('employee')
                        ->whereBetween('shift_date', [$this->startDate, $this->endDate])
                        ->where('type', ShiftType::WFH)
                        ->orderBy('shift_date')
                        ->get();
                }

                public function title(): string
            {
                    return 'WFH Shift';
                }
            },
        ];
    }
}
