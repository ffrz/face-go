<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        return inertia('employee/attendance/Index');
    }

    public function checkIn(Request $request)
    {
        if ($request->method() == 'GET') {
            return inertia('employee/attendance/CheckIn');
        }

        $request->validate([
            'photo' => 'required|image',
            'location' => 'required|string',
        ]);

        $employeeId = Auth::guard('employee')->id();
        $date = Carbon::today();

        // Upload photo
        $photoPath = $request->file('photo')->store('attendance_photos', 'public');

        // Insert or update attendance
        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $date],
            [
                'check_in_time' => now(),
                'check_in_photo' => $photoPath,
                'check_in_location' => $request->location,
            ]
        );

        return redirect()->route('employee.dashboard.index')->with('success', 'Check-in successful.');
    }

    public function checkOut(Request $request)
    {
        if ($request->method() == 'GET') {
            return inertia('employee/attendance/CheckOut');
        }

        $request->validate([
            'photo' => 'required|image',
            'location' => 'required|string',
        ]);

        $employeeId = Auth::guard('employee')->id();
        $date = Carbon::today();

        // Upload photo
        $photoPath = $request->file('photo')->store('attendance_photos', 'public');

        // Update existing record
        $attendance = Attendance::where('employee_id', $employeeId)->where('date', $date)->firstOrFail();
        $attendance->update([
            'check_out_time' => now(),
            'check_out_photo' => $photoPath,
            'check_out_location' => $request->location,
        ]);

        return redirect()->route('employee.dashboard.index')->with('success', 'Check-out successful.');
    }

    public function history()
    {
        return inertia('employee/attendance/History');
    }

    public function historyData(Request $request)
    {
        $employeeId = Auth::guard('employee')->id();
        $query = Attendance::where('employee_id', $employeeId)
            ->orderByDesc('date');

        return response()->json([
            'rows' => $query->paginate($request->input('rowsPerPage', 10)),
        ]);
    }
}
