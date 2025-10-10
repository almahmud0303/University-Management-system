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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';