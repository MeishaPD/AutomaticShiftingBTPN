<?php
namespace App\Exports;

use App\Models\Employee;
use App\Models\EmployeeShift;

class IndividualShiftExport extends BaseShiftExport
{
    protected $nik;

    public function __construct($startDate, $endDate, $nik)
    {
        parent::__construct($startDate, $endDate);
        $this->nik = $nik;
    }

    public function collection()
    {
        $employee = Employee::where('nik', $this->nik)->firstOrFail();

        return EmployeeShift::with('employee')
            ->where('employee_id', $employee->id)
            ->whereBetween('shift_date', [$this->startDate, $this->endDate])
            ->orderBy('shift_date')
            ->get();
    }
}
