<?php
namespace App\Http\Controllers;

use App\Enums\ShiftType;
use App\Models\Employee;
use App\Models\EmployeeShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestShiftingController extends Controller
{
    public function index()
    {
        return view('RequestShifting');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'        => 'required|string|size:16|exists:employees,nik',
            'shift_type' => 'required|in:WFO,WFH',
            'shift_date' => 'required|date|after_or_equal:today',
        ], [
            'nik.required'              => 'NIK wajib diisi',
            'nik.size'                  => 'NIK harus tepat 16 digit',
            'nik.exists'                => 'Karyawan dengan NIK tersebut tidak ditemukan',
            'shift_type.required'       => 'Tipe shift wajib diisi',
            'shift_type.in'             => 'Tipe shift harus WFO atau WFH',
            'shift_date.required'       => 'Tanggal shift wajib diisi',
            'shift_date.date'           => 'Format tanggal tidak valid',
            'shift_date.after_or_equal' => 'Tanggal shift harus hari ini atau setelahnya',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee = Employee::where('nik', $request->nik)->first();

        $existingShift = EmployeeShift::where('employee_id', $employee->id)
            ->where('shift_date', $request->shift_date)
            ->first();

        if ($existingShift) {
            return redirect()->back()
                ->withErrors(['shift_date' => 'Karyawan sudah memiliki shift pada tanggal tersebut'])
                ->withInput();
        }

        $currentShifts = EmployeeShift::where('shift_date', $request->shift_date)->get();
        $wfoCount      = $currentShifts->where('type', ShiftType::WFO)->count();
        $wfhCount      = $currentShifts->where('type', ShiftType::WFH)->count();

        if ($request->shift_type === ShiftType::WFO->value && $wfoCount >= 3) {
            return redirect()->back()
                ->withErrors(['shift_type' => 'Quota WFO untuk tanggal tersebut sudah penuh'])
                ->withInput();
        }

        if ($request->shift_type === ShiftType::WFH->value && $wfhCount >= 2) {
            return redirect()->back()
                ->withErrors(['shift_type' => 'Quota WFH untuk tanggal tersebut sudah penuh'])
                ->withInput();
        }

        EmployeeShift::create([
            'employee_id' => $employee->id,
            'type'        => $request->shift_type,
            'shift_date'  => $request->shift_date,
        ]);

        return redirect()->route('dashboard');
    }
}
