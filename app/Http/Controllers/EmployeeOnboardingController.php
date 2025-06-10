<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeOnboardingController extends Controller
{
    public function index(Request $request)
    {
        $perPage        = $request->get('per_page', 10);
        $perPageOptions = [10, 25, 50, 100];

        $employees = Employee::where('is_onboarding', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('employee-onboarding.index', compact('employees', 'perPageOptions', 'perPage'));
    }
}
