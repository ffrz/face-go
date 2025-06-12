<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File; // untuk cek/membuat folder

class AttendanceController extends Controller
{
    public function index()
    {
        return inertia('employee/attendance/Index');
    }

    public function checkIn(Request $request)
    {
        $employeeId = Auth::guard('employee')->user()->id;
        $date = Carbon::today();

        if ($request->method() === 'GET') {
            $attendance = Attendance::where('employee_id', $employeeId)
                ->where('date', $date)
                ->first();

            if ($attendance) {
                return redirect()->route('employee.dashboard.index')->with('warning', 'Anda sudah check in.');
            }

            return inertia('employee/attendance/CheckIn', [
                'attendance' => $attendance,
            ]);
        }

        $request->validate([
            'photo' => 'required|image|max:2048', // opsional: batas 2MB
            'location' => 'required|string',
        ]);

        // Persiapan upload
        $photo = $request->file('photo');
        $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
        $folderPath = public_path('attendance_photos');

        // Buat folder jika belum ada
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Resize dan simpan
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $resizedImage = $manager->read($photo)->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedImage->save($folderPath . '/' . $filename);

        $photoPath = 'attendance_photos/' . $filename;

        // Simpan ke database
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
        $employeeId = Auth::guard('employee')->user()->id;
        $date = Carbon::today();

        if ($request->method() === 'GET') {
            $attendance = Attendance::where('employee_id', $employeeId)
                ->where('date', $date)
                ->first();

            if ($attendance) {
                return redirect()->route('employee.dashboard.index')->with('warning', 'Anda sudah check out.');
            }

            return inertia('employee/attendance/CheckOut', [
                'attendance' => $attendance,
            ]);
        }

        $request->validate([
            'photo' => 'required|image|max:2048', // opsional: batas 2MB
            'location' => 'required|string',
        ]);

        // Persiapan upload
        $photo = $request->file('photo');
        $filename = uniqid() . '.' . $photo->getClientOriginalExtension();
        $folderPath = public_path('attendance_photos');

        // Buat folder jika belum ada
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Resize dan simpan
        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        $resizedImage = $manager->read($photo)->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedImage->save($folderPath . '/' . $filename);

        $photoPath = 'attendance_photos/' . $filename;

        // Simpan ke database
        Attendance::updateOrCreate(
            ['employee_id' => $employeeId, 'date' => $date],
            [
                'check_out_time' => now(),
                'check_out_photo' => $photoPath,
                'check_out_location' => $request->location,
            ]
        );

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
