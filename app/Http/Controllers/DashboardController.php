<?php
namespace App\Http\Controllers;

use App\Services\ShiftGeneratorService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ShiftGeneratorService $shiftGenerator
    ) {}

    public function index()
    {
        $this->shiftGenerator->generateShiftsForNextMonth();

        return view('Dashboard');
    }
}
