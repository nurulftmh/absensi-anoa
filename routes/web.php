<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('admin.dashboard');
    }

    return app(AttendanceController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Semua fitur user & admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ABSEN
    Route::post('/absen-masuk', [AttendanceController::class, 'checkIn'])
        ->name('attendance.checkin');

    Route::post('/absen-pulang', [AttendanceController::class, 'checkOut'])
        ->name('attendance.checkout');

    // PROGRES
    Route::post('/progres-kerja', [AttendanceController::class, 'storeProgress'])
        ->name('work.progress.store');

    // IZIN
    Route::post('/izin', [LeaveRequestController::class, 'store'])
        ->name('leave.store');

    Route::get('/admin/izin', [LeaveRequestController::class, 'adminIndex'])
        ->name('admin.leave.index');

    Route::post('/admin/izin/{id}/approve', [LeaveRequestController::class, 'approve'])
        ->name('admin.leave.approve');

    Route::post('/admin/izin/{id}/reject', [LeaveRequestController::class, 'reject'])
        ->name('admin.leave.reject');

    // ADMIN ABSENSI
    Route::get('/admin/absensi', [AttendanceController::class, 'adminAttendance'])
        ->name('admin.attendance.index');

    // ADMIN PROGRES
    Route::get('/admin/progres', [AttendanceController::class, 'adminProgress'])
        ->name('admin.progress.index');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';