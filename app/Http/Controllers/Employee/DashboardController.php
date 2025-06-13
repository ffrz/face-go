<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $employeeId = Auth::guard('employee')->user()->id;
        $date = Carbon::today();

        return inertia('employee/dashboard/Index', [
            'data' => [
                'today_attendance' => Attendance::where('employee_id', $employeeId)
                    ->where('date', $date)
                    ->first()
            ]
        ]);
    }
}
