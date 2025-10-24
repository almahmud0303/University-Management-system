<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    
    // Department Management
    Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
    
    // Course Management
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    
    // Hall Management
    Route::resource('halls', App\Http\Controllers\Admin\HallController::class);
    Route::post('halls/{hall}/assign-student', [App\Http\Controllers\Admin\HallController::class, 'assignStudent'])->name('halls.assign-student');
    Route::delete('students/{student}/remove-from-hall', [App\Http\Controllers\Admin\HallController::class, 'removeStudent'])->name('halls.remove-student');
    
    // Fee Management
    Route::resource('fees', App\Http\Controllers\Admin\FeeController::class);
    Route::patch('fees/{fee}/mark-paid', [App\Http\Controllers\Admin\FeeController::class, 'markPaid'])->name('fees.mark-paid');
    
    // Notice Management
    Route::resource('notices', App\Http\Controllers\Admin\NoticeController::class);
    Route::patch('notices/{notice}/publish', [App\Http\Controllers\Admin\NoticeController::class, 'publish'])->name('notices.publish');
    
    // Exam Management
    Route::resource('exams', App\Http\Controllers\Admin\ExamController::class);
});
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

// Teacher Routes
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:teacher', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [App\Http\Controllers\Teacher\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [App\Http\Controllers\Teacher\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/update-password', [App\Http\Controllers\Teacher\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    
    // Course routes
    Route::prefix('courses')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\CourseController::class, 'index'])->name('courses.index');
        Route::get('/{course}', [App\Http\Controllers\Teacher\CourseController::class, 'show'])->name('courses.show');
        Route::get('/{course}/students', [App\Http\Controllers\Teacher\CourseController::class, 'students'])->name('courses.students');
        Route::post('/{course}/enroll-student', [App\Http\Controllers\Teacher\CourseController::class, 'enrollStudent'])->name('courses.enroll-student');
        Route::delete('/{course}/students/{student}', [App\Http\Controllers\Teacher\CourseController::class, 'removeStudent'])->name('courses.remove-student');
    });
    
    // Exam routes
    Route::prefix('exams')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\ExamController::class, 'index'])->name('exams.index');
        Route::get('/create', [App\Http\Controllers\Teacher\ExamController::class, 'create'])->name('exams.create');
        Route::post('/', [App\Http\Controllers\Teacher\ExamController::class, 'store'])->name('exams.store');
        Route::get('/{exam}', [App\Http\Controllers\Teacher\ExamController::class, 'show'])->name('exams.show');
        Route::get('/{exam}/edit', [App\Http\Controllers\Teacher\ExamController::class, 'edit'])->name('exams.edit');
        Route::put('/{exam}', [App\Http\Controllers\Teacher\ExamController::class, 'update'])->name('exams.update');
        Route::delete('/{exam}', [App\Http\Controllers\Teacher\ExamController::class, 'destroy'])->name('exams.destroy');
        Route::get('/{exam}/enter-marks', [App\Http\Controllers\Teacher\ExamController::class, 'enterMarks'])->name('exams.enter-marks');
        Route::post('/{exam}/store-marks', [App\Http\Controllers\Teacher\ExamController::class, 'storeMarks'])->name('exams.store-marks');
    });
    
    // Result routes
    Route::prefix('results')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\ResultController::class, 'index'])->name('results.index');
        Route::get('/{result}/edit', [App\Http\Controllers\Teacher\ResultController::class, 'edit'])->name('results.edit');
        Route::put('/{result}', [App\Http\Controllers\Teacher\ResultController::class, 'update'])->name('results.update');
        Route::patch('/{result}/publish', [App\Http\Controllers\Teacher\ResultController::class, 'publish'])->name('results.publish');
        Route::patch('/{result}/unpublish', [App\Http\Controllers\Teacher\ResultController::class, 'unpublish'])->name('results.unpublish');
        Route::patch('/exams/{exam}/publish-all', [App\Http\Controllers\Teacher\ResultController::class, 'publishAll'])->name('results.publish-all');
    });
    
    // Academic routes
    Route::get('/academic', function () {
        $teacher = \Illuminate\Support\Facades\Auth::user()->teacher;
        $teacher->load(['department', 'courses.department']);
        return view('teacher.academic', compact('teacher'));
    })->name('academic');
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