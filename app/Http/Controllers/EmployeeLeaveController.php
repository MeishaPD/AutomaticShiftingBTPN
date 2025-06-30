<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

        if ($request->leave_type === 'yearly') {
            $leaveYear = date('Y', strtotime($request->leave_start));
            $existingLeaves = EmployeeLeave::where('employee_id', $employee->id)
                ->where('type', 'yearly')
                ->whereYear('leave_start', $leaveYear)
                ->get();

            $totalLeaveDaysUsed = $this->calculateTotalYearlyLeaveDays($existingLeaves);
            $newLeaveDays = $this->calculateLeaveDays($request->leave_start, $request->leave_end);

            if (($totalLeaveDaysUsed + $newLeaveDays) > 12) {
                $remainingDays = 12 - $totalLeaveDaysUsed;
                return redirect()->back()
                    ->withErrors([
                        'leave_start' => "Karyawan sudah mengambil {$totalLeaveDaysUsed} hari cuti tahunan di tahun ini. " .
                                       "Pengajuan cuti {$newLeaveDays} hari akan melebihi batas maksimal 12 hari. " .
                                       "Sisa cuti tahunan yang tersedia: {$remainingDays} hari."
                    ])
                    ->withInput();
            }
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

    private function calculateTotalYearlyLeaveDays($leaves)
    {
        $totalDays = 0;
        
        foreach ($leaves as $leave) {
            if ($leave->type === 'yearly') {
                $totalDays += $this->calculateLeaveDays($leave->leave_start, $leave->leave_end);
            }
        }
        
        return $totalDays;
    }

    private function calculateTotalLeaveDays($leaves)
    {
        $totalDays = 0;
        
        foreach ($leaves as $leave) {
            if ($leave->type === 'yearly') {
                $totalDays += $this->calculateLeaveDays($leave->leave_start, $leave->leave_end);
            } else {
                $totalDays += 1;
            }
        }
        
        return $totalDays;
    }

    private function calculateLeaveDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        return $start->diffInDays($end) + 1;
    }

    public function report(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $nik            = $request->get('nik');
        $startDate      = $request->get('start_date');
        $endDate        = $request->get('end_date');
        $onlyWithLeaves = $request->boolean('only_with_leaves');

        $query = EmployeeLeave::with('employee');

        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
               $q->whereBetween('leave_start', [$startDate, $endDate])
                 ->orWhereBetween('leave_end', [$startDate, $endDate])
                 ->orWhere(function ($subQ) use ($startDate, $endDate) {
                      $subQ->where('leave_start', '<=', $startDate)
                           ->where('leave_end', '>=', $endDate);
                });
            });
        } elseif ($startDate) {
            $query->where('leave_start', '>=', $startDate);
        } elseif ($endDate) {
         $query->where('leave_end', '<=', $endDate);
        }

        if ($nik) {
            $query->whereHas('employee', function ($q) use ($nik) {
              $q->where('nik', 'like', "%{$nik}%");
            });
        }

        if (!$onlyWithLeaves) {
            $employeeQuery = Employee::query();
        
            if ($nik) {
               $employeeQuery->where('nik', 'like', "%{$nik}%");
            }
        
            $allEmployees = $employeeQuery->get();
            $leaveRecords = $query->get();
        
            $leaveRows = new Collection();
        
            foreach ($leaveRecords as $leave) {
                $leaveDays = $this->calculateLeaveDaysForReport($leave);
                
                $leaveRows->push([
                    'employee_id' => $leave->employee->id,
                    'nik'         => $leave->employee->nik,
                    'name'        => $leave->employee->name,
                    'gender'      => $leave->employee->gender,
                    'location'    => $leave->employee->location,
                    'leave_start' => $leave->leave_start->format('Y-m-d'),
                    'leave_end'   => $leave->leave_end->format('Y-m-d'),
                    'leave_days'  => $leaveDays,
                    'type'        => $leave->type,
                    'has_leave'   => true
                ]);
            }
        
            if (!$startDate && !$endDate) {
                $employeesWithLeaves = $leaveRecords->pluck('employee.id')->unique();
                
                foreach ($allEmployees as $employee) {
                    if (!$employeesWithLeaves->contains($employee->id)) {
                        $leaveRows->push([
                            'employee_id' => $employee->id,
                            'nik'         => $employee->nik,
                            'name'        => $employee->name,
                            'gender'      => $employee->gender,
                            'location'    => $employee->location,
                            'leave_start' => null,
                            'leave_end'   => null,
                            'leave_days'  => 0,
                            'type'        => null,
                            'has_leave'   => false
                        ]);
                    }
                }
            }
            
            $leaveRows = $leaveRows->sortBy([
                ['leave_start', 'asc'],
                ['name', 'asc']
            ]);
            
        } else {
            $leaveRecords = $query->orderBy('leave_start', 'asc')->get();
        
            $leaveRows = $leaveRecords->map(function ($leave) {
                $leaveDays = $this->calculateLeaveDaysForReport($leave);
                
                return [
                    'employee_id' => $leave->employee->id,
                    'nik'         => $leave->employee->nik,
                    'name'        => $leave->employee->name,
                    'gender'      => $leave->employee->gender,
                    'location'    => $leave->employee->location,
                    'leave_start' => $leave->leave_start->format('Y-m-d'),
                    'leave_end'   => $leave->leave_end->format('Y-m-d'),
                    'leave_days'  => $leaveDays,
                    'type'        => $leave->type,
                    'has_leave'   => true
                ];
            });
        }

        $page = $request->get('page', 1);
        $leaveRows = new \Illuminate\Pagination\LengthAwarePaginator(
            $leaveRows->forPage($page, $perPage),
            $leaveRows->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('LeaveReport', [
            'leaveRows'      => $leaveRows,
            'perPageOptions' => $perPageOptions,
            'perPage'        => $perPage,
            'nik'            => $nik,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'onlyWithLeaves' => $onlyWithLeaves,
        ]);
    }

    private function calculateLeaveDaysForReport($leave)
    {
        return $this->calculateLeaveDays($leave->leave_start, $leave->leave_end);
    }
}