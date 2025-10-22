<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'student':
            return redirect()->route('student.dashboard');
        case 'staff':
            return redirect()->route('staff.dashboard');
        case 'department_head':
            return redirect()->route('department-head.dashboard');
        default:
            return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Teacher Routes
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:teacher', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');
});

// Student Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');
});

// Staff Routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');
});

// Department Head Routes
Route::prefix('department-head')->name('department-head.')->middleware(['auth', 'role:department_head', 'prevent-back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('department-head.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';