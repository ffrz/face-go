<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File; // untuk cek/membuat folder
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function index()
    {
        return inertia('employee/attendance/Index');
    }

    public function checkIn(Request $request)
    {
        return $this->handleAttendance($request, 'check_in');
    }

    public function checkOut(Request $request)
    {
        return $this->handleAttendance($request, 'check_out');
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

    private function handleAttendance(Request $request, string $type)
    {
        $employeeId = Auth::guard('employee')->user()->id;
        $date = Carbon::today();

        $fieldTime = "{$type}_time"; // check_in_time / check_out_time
        $fieldPhoto = "{$type}_photo";
        $fieldLocation = "{$type}_location";
        $viewName = Str::studly($type); // CheckIn / CheckOut

        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();

        if ($attendance && $attendance->$fieldTime) {
            return redirect()->route('employee.dashboard.index')->with('warning', "Anda sudah " . ($type === 'check_in' ? 'check in' : 'check out.'));
        }

        if ($type == 'check_out' && !$attendance) {
            return redirect()->route('employee.dashboard.index')->with('warning', "Anda tidak bisa check out karena belum check in hari ini.");
        }

        if ($request->isMethod('get')) {
            return inertia("employee/attendance/{$viewName}");
        }

        $request->validate([
            'photo' => 'required|image|max:2048',
            'location' => 'required|string',
        ]);

        $photo = $request->file('photo');
        $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
        $folderPath = public_path('attendance_photos');

        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $resizedImage = $manager->read($photo)->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedImage->save($folderPath . '/' . $filename);

        $photoPath = 'attendance_photos/' . $filename;

        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $date],
            [
                $fieldTime => now(),
                $fieldPhoto => $photoPath,
                $fieldLocation => $request->location,
            ]
        );

        return redirect()->route('employee.dashboard.index')
            ->with('success', ucfirst(str_replace('_', '-', $type)) . ' berhasil.');
    }
}
