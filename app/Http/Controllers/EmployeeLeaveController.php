<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeLeaveController extends Controller
{
    public function create()
    {
        return view('leave-onboarding.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'           => 'required|string|size:16|exists:employees,nik',
            'employee_name' => 'required|string',
            'leave_start'   => 'required|date|after_or_equal:today',
            'leave_end'     => 'required|date|after_or_equal:leave_start',
            'leave_type'    => 'required|in:yearly,special',
        ], [
            'nik.required'               => 'NIK wajib diisi',
            'nik.size'                   => 'NIK harus tepat 16 digit',
            'nik.exists'                 => 'Karyawan dengan NIK tersebut tidak ditemukan',
            'employee_name.required'     => 'Nama karyawan wajib diisi',
            'leave_start.required'       => 'Tanggal cuti mulai wajib diisi',
            'leave_start.date'           => 'Format tanggal mulai tidak valid',
            'leave_start.after_or_equal' => 'Tanggal cuti mulai harus hari ini atau setelahnya',
            'leave_end.required'         => 'Tanggal cuti berakhir wajib diisi',
            'leave_end.date'             => 'Format tanggal berakhir tidak valid',
            'leave_end.after_or_equal'   => 'Tanggal cuti berakhir harus setelah atau sama dengan tanggal mulai',
            'leave_type.required'        => 'Tipe cuti wajib dipilih',
            'leave_type.in'              => 'Tipe cuti tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee = Employee::where('nik', $request->nik)->first();

        if (! $employee) {
            return redirect()->back()
                ->withErrors(['nik' => 'Karyawan tidak ditemukan'])
                ->withInput();
        }

        if (! $employee->is_onboarding) {
            return redirect()->back()
                ->withErrors(['nik' => 'Karyawan ini tidak dalam status onboarding'])
                ->withInput();
        }

        if (trim(strtolower($employee->name)) !== trim(strtolower($request->employee_name))) {
            return redirect()->back()
                ->withErrors(['employee_name' => 'Nama karyawan tidak sesuai dengan NIK'])
                ->withInput();
        }

        $leaveYear  = date('Y', strtotime($request->leave_start));
        $leaveCount = EmployeeLeave::where('employee_id', $employee->id)
            ->whereYear('leave_start', $leaveYear)
            ->count();

        if ($leaveCount >= 12) {
            return redirect()->back()
                ->withErrors(['leave_start' => 'Karyawan sudah mengambil cuti sebanyak 12 kali di tahun ini'])
                ->withInput();
        }

        EmployeeLeave::create([
            'employee_id' => $employee->id,
            'type'        => $request->leave_type,
            'leave_start' => $request->leave_start,
            'leave_end'   => $request->leave_end,
        ]);

        return redirect()->route('employee.leave')
            ->with('success', 'Pengajuan cuti berhasil disimpan.');
    }
}
