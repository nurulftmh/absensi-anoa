<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'reason' => 'required|string',
        'proof_file' => 'nullable|file|max:5120',
    ], [
        'date.after_or_equal' => 'Tanggal izin tidak boleh tanggal yang sudah berlalu.',
    ]);

    $attendance = Attendance::where('user_id', auth()->id())
        ->where('date', $request->date)
        ->first();

    if ($attendance && $attendance->check_in) {
        return back()->with('error', 'Kamu sudah absen di tanggal ini, tidak bisa mengajukan izin.');
    }

    $proofPath = null;

    if ($request->hasFile('proof_file')) {
        $proofPath = $request->file('proof_file')->store('leave-proofs', 'public');
    }

    LeaveRequest::create([
        'user_id' => auth()->id(),
        'date' => $request->date,
        'reason' => $request->reason,
        'proof_file' => $proofPath,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Pengajuan izin berhasil dikirim ke pimpinan.');
}

    public function adminIndex()
    {
        $requests = LeaveRequest::with('user')->latest()->get();

        return view('admin.leave-requests', compact('requests'));
    }

    public function approve($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'approved',
        ]);

        Attendance::updateOrCreate(
            [
                'user_id' => $leave->user_id,
                'date' => $leave->date,
            ],
            [
                'status' => 'izin',
                'check_in' => null,
                'check_out' => null,
            ]
        );

        return back()->with('success', 'Izin disetujui. Status absensi berubah menjadi IZIN.');
    }

    public function reject($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $leave->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Izin berhasil ditolak.');
    }
}