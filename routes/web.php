<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isTeacher() || $user->isDepartmentHead()) {
        if ($user->teacher && $user->teacher->isDepartmentHead()) {
            return redirect()->route('department-head.dashboard');
        }
        return redirect()->route('teacher.dashboard');
    } elseif ($user->isStudent()) {
        return redirect()->route('student.dashboard');
    } elseif ($user->isStaff()) {
        return redirect()->route('staff.dashboard');
    }

    abort(403, 'Unauthorized access');
})->middleware(['auth', 'verified', 'prevent-back'])->name('dashboard');

Route::middleware(['auth', 'role:admin', 'prevent-back'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
});

require __DIR__.'/auth.php';