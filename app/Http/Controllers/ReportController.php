<?php
namespace App\Http\Controllers;

use App\Exports\AllShiftsExport;
use App\Exports\IndividualShiftExport;
use App\Models\EmployeeShift;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('Report');
    }

    public function download(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:semua,individu',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'nik'         => 'required_if:report_type,individu|nullable|exists:employees,nik',
        ], [
            'report_type.required'    => 'Tipe laporan harus dipilih',
            'report_type.in'          => 'Tipe laporan tidak valid',
            'start_date.required'     => 'Tanggal mulai harus diisi',
            'start_date.date'         => 'Format tanggal mulai tidak valid',
            'end_date.required'       => 'Tanggal selesai harus diisi',
            'end_date.date'           => 'Format tanggal selesai tidak valid',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama dengan atau setelah tanggal mulai',
            'nik.required_if'         => 'NIK harus diisi untuk laporan individu',
            'nik.exists'              => 'NIK tidak ditemukan',
        ]);

        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $fileName  = 'shift_report_' . date('Y-m-d_His') . '.xlsx';

        if ($request->report_type === 'semua') {
            return Excel::download(new AllShiftsExport($startDate, $endDate), $fileName);
        } else {
            $employee  = \App\Models\Employee::where('nik', $request->nik)->first();
            $hasShifts = EmployeeShift::where('employee_id', $employee->id)
                ->whereBetween('shift_date', [$startDate, $endDate])
                ->exists();

            if (! $hasShifts) {
                return back()->withErrors([
                    'nik' => 'Karyawan tidak memiliki jadwal shift pada rentang tanggal yang dipilih',
                ]);
            }

            return Excel::download(
                new IndividualShiftExport($startDate, $endDate, $request->nik),
                $fileName
            );
        }
    }
}
