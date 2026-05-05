<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\WorkProgress;
use App\Models\WorkFile;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        $attendances = Attendance::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard', compact('attendance', 'attendances'));
    }

    public function checkIn()
    {
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        if ($attendance) {
            return back()->with('error', 'Kamu sudah melakukan absen masuk hari ini.');
        }

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => $today,
            'check_in' => now()->format('H:i:s'),
            'status' => 'hadir',
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function checkOut()
    {
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Kamu belum melakukan absen masuk.');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'Kamu sudah melakukan absen pulang.');
        }

        $checkInTime = Carbon::parse($attendance->date . ' ' . $attendance->check_in);
        $allowedCheckOut = $checkInTime->copy()->addHours(8);

        if (now()->lt($allowedCheckOut)) {
            return back()->with('error', 'Belum bisa absen pulang. Minimal 8 jam kerja dari waktu absen masuk.');
        }

        $attendance->update([
            'check_out' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }

    public function storeProgress(Request $request)
{
    $request->validate([
        'description' => 'required|string',
        'files.*' => 'nullable|file|max:5120',
    ]);

    $today = now()->toDateString();

    $attendance = Attendance::where('user_id', auth()->id())
        ->where('date', $today)
        ->first();

    if (!$attendance) {
        return back()->with('error', 'Silakan absen masuk dulu.');
    }

    $progress = WorkProgress::create([
        'attendance_id' => $attendance->id,
        'description' => $request->description,
    ]);

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $path = $file->store('work-files', 'public');

            WorkFile::create([
                'work_progress_id' => $progress->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }
    }

    return back()->with('success', 'Progres kerja berhasil disimpan.');
}

public function adminAttendance()
{
    $attendances = Attendance::with('user')->latest()->get();

    return view('admin.attendance', compact('attendances'));
}

public function adminProgress()
{
    $progress = WorkProgress::with(['attendance.user', 'files'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.progress', compact('progress'));
}

}