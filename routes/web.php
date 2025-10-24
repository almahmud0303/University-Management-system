<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [App\Http\Controllers\Admin\DashboardController::class, 'analytics'])->name('analytics');
    
    // Department Management
    Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
    Route::post('departments/{department}/toggle-status', [App\Http\Controllers\Admin\DepartmentController::class, 'toggleStatus'])->name('departments.toggle-status');
    
    // User Management
    Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
    Route::get('teachers/{teacher}/credentials', [App\Http\Controllers\Admin\TeacherController::class, 'credentials'])->name('teachers.credentials');
    
    Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
    Route::get('students/{student}/credentials', [App\Http\Controllers\Admin\StudentController::class, 'credentials'])->name('students.credentials');
    
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    
    // Course Management
    Route::get('courses/organize', [App\Http\Controllers\Admin\CourseManagementController::class, 'organize'])->name('courses.organize');
    Route::post('courses/bulk-assign', [App\Http\Controllers\Admin\CourseManagementController::class, 'bulkAssign'])->name('courses.bulk-assign');
    Route::get('courses/department/{departmentId}', [App\Http\Controllers\Admin\CourseManagementController::class, 'getByDepartment'])->name('courses.by-department');
    Route::resource('courses', App\Http\Controllers\Admin\CourseManagementController::class);
    
    // Exam Management
    Route::resource('exams', App\Http\Controllers\Admin\ExamController::class);
    
    // Result Management
    Route::resource('results', App\Http\Controllers\Admin\ResultController::class);
    
    // Fee Management
    Route::resource('fees', App\Http\Controllers\Admin\FeeController::class);
    Route::patch('fees/{fee}/mark-paid', [App\Http\Controllers\Admin\FeeController::class, 'markPaid'])->name('fees.mark-paid');
    
    // Book Management
    Route::resource('books', App\Http\Controllers\Admin\BookController::class);
    Route::post('books/{book}/issue', [App\Http\Controllers\Admin\BookController::class, 'issueBook'])->name('books.issue');
    Route::patch('book-issues/{bookIssue}/return', [App\Http\Controllers\Admin\BookController::class, 'returnBook'])->name('book-issues.return');
    
    // Notice Management
    Route::resource('notices', App\Http\Controllers\Admin\NoticeController::class);
    Route::patch('notices/{notice}/publish', [App\Http\Controllers\Admin\NoticeController::class, 'publish'])->name('notices.publish');
    
    // Hall Management
    Route::resource('halls', App\Http\Controllers\Admin\HallController::class);
    Route::post('halls/{hall}/assign-student', [App\Http\Controllers\Admin\HallController::class, 'assignStudent'])->name('halls.assign-student');
    Route::delete('students/{student}/remove-from-hall', [App\Http\Controllers\Admin\HallController::class, 'removeStudent'])->name('halls.remove-student');
});

// Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/fee/{fee}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/fee/{fee}/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
    Route::get('/payment/cancel', [PaymentController::class, 'handleCancel'])->name('payment.cancel');
    Route::get('/payment/fail', [PaymentController::class, 'handleFail'])->name('payment.fail');
    Route::get('/payment/history', [PaymentController::class, 'getPaymentHistory'])->name('payment.history');
    Route::get('/payment/stats', [PaymentController::class, 'getPaymentStats'])->name('payment.stats');
    
    // Test routes (only in sandbox mode)
    Route::get('/payment/bkash-test/{paymentId}', [PaymentController::class, 'testBkashPayment'])->name('payment.test');
    Route::post('/payment/simulate-success/{paymentId}', [PaymentController::class, 'simulateSuccess'])->name('payment.simulate');
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
    
    // Assignment routes
    Route::prefix('assignments')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/create', [App\Http\Controllers\Teacher\AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/', [App\Http\Controllers\Teacher\AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/{assignment}', [App\Http\Controllers\Teacher\AssignmentController::class, 'show'])->name('assignments.show');
        Route::get('/{assignment}/edit', [App\Http\Controllers\Teacher\AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/{assignment}', [App\Http\Controllers\Teacher\AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/{assignment}', [App\Http\Controllers\Teacher\AssignmentController::class, 'destroy'])->name('assignments.destroy');
        Route::get('/{assignment}/submissions', [App\Http\Controllers\Teacher\AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::patch('/submissions/{submission}/grade', [App\Http\Controllers\Teacher\AssignmentController::class, 'gradeSubmission'])->name('assignments.grade');
    });
    
    // Notice routes
    Route::prefix('notices')->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\NoticeController::class, 'index'])->name('notices.index');
        Route::get('/{notice}', [App\Http\Controllers\Teacher\NoticeController::class, 'show'])->name('notices.show');
    });
});

// Student Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student', 'prevent-back', 'auto-enroll'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [App\Http\Controllers\Student\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/update-password', [App\Http\Controllers\Student\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    
    // Course routes
    Route::prefix('courses')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses.index');
        Route::get('/available', [App\Http\Controllers\Student\CourseController::class, 'available'])->name('courses.available');
    });
    
    // Course Enrollment routes
    Route::prefix('enrollment')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\CourseEnrollmentController::class, 'index'])->name('enrollment.index');
        Route::post('/enroll/{course}', [App\Http\Controllers\Student\CourseEnrollmentController::class, 'enroll'])->name('enrollment.enroll');
        Route::delete('/drop/{course}', [App\Http\Controllers\Student\CourseEnrollmentController::class, 'drop'])->name('enrollment.drop');
    });
    
    // Exam routes
    Route::prefix('exams')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\ExamController::class, 'index'])->name('exams.index');
        Route::get('/{exam}', [App\Http\Controllers\Student\ExamController::class, 'show'])->name('exams.show');
    });
    
    // Result routes
    Route::prefix('results')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\ResultController::class, 'index'])->name('results.index');
        Route::get('/gpa', [App\Http\Controllers\Student\ResultController::class, 'gpa'])->name('results.gpa');
    });
    
    // Library routes
    Route::prefix('library')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\LibraryController::class, 'index'])->name('library.index');
        Route::get('/books', [App\Http\Controllers\Student\LibraryController::class, 'books'])->name('library.books');
        Route::post('/request/{book}', [App\Http\Controllers\Student\LibraryController::class, 'requestBook'])->name('library.request');
        Route::post('/return/{bookIssue}', [App\Http\Controllers\Student\LibraryController::class, 'returnBook'])->name('library.return');
    });
    
    // Fee routes
    Route::prefix('fees')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\FeeController::class, 'index'])->name('fees.index');
    });
    
    // Payment routes
    Route::prefix('payments')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/create/{fee}', [App\Http\Controllers\Student\PaymentController::class, 'create'])->name('payments.create');
        Route::post('/process/{fee}', [App\Http\Controllers\Student\PaymentController::class, 'process'])->name('payments.process');
    });
});

// Staff Routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [App\Http\Controllers\Staff\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [App\Http\Controllers\Staff\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [App\Http\Controllers\Staff\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/update-password', [App\Http\Controllers\Staff\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    
    // Library routes
    Route::prefix('library')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\LibraryController::class, 'index'])->name('library.index');
        Route::get('/create', [App\Http\Controllers\Staff\LibraryController::class, 'create'])->name('library.create');
        Route::post('/', [App\Http\Controllers\Staff\LibraryController::class, 'store'])->name('library.store');
        Route::get('/{book}', [App\Http\Controllers\Staff\LibraryController::class, 'show'])->name('library.show');
        Route::get('/{book}/edit', [App\Http\Controllers\Staff\LibraryController::class, 'edit'])->name('library.edit');
        Route::put('/{book}', [App\Http\Controllers\Staff\LibraryController::class, 'update'])->name('library.update');
        Route::delete('/{book}', [App\Http\Controllers\Staff\LibraryController::class, 'destroy'])->name('library.destroy');
    });
    
    // Book Issue routes
    Route::prefix('book-issues')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\BookIssueController::class, 'index'])->name('book-issues.index');
        Route::get('/create', [App\Http\Controllers\Staff\BookIssueController::class, 'create'])->name('book-issues.create');
        Route::post('/', [App\Http\Controllers\Staff\BookIssueController::class, 'store'])->name('book-issues.store');
        Route::get('/{bookIssue}', [App\Http\Controllers\Staff\BookIssueController::class, 'show'])->name('book-issues.show');
        Route::patch('/{bookIssue}/approve', [App\Http\Controllers\Staff\BookIssueController::class, 'approve'])->name('book-issues.approve');
        Route::patch('/{bookIssue}/reject', [App\Http\Controllers\Staff\BookIssueController::class, 'reject'])->name('book-issues.reject');
        Route::patch('/{bookIssue}/return', [App\Http\Controllers\Staff\BookIssueController::class, 'return'])->name('book-issues.return');
        Route::patch('/{bookIssue}/renew', [App\Http\Controllers\Staff\BookIssueController::class, 'renew'])->name('book-issues.renew');
    });
    
    // Hall routes
    Route::prefix('halls')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\HallController::class, 'index'])->name('halls.index');
        Route::get('/create', [App\Http\Controllers\Staff\HallController::class, 'create'])->name('halls.create');
        Route::post('/', [App\Http\Controllers\Staff\HallController::class, 'store'])->name('halls.store');
        Route::get('/{hall}', [App\Http\Controllers\Staff\HallController::class, 'show'])->name('halls.show');
        Route::get('/{hall}/edit', [App\Http\Controllers\Staff\HallController::class, 'edit'])->name('halls.edit');
        Route::put('/{hall}', [App\Http\Controllers\Staff\HallController::class, 'update'])->name('halls.update');
        Route::delete('/{hall}', [App\Http\Controllers\Staff\HallController::class, 'destroy'])->name('halls.destroy');
        Route::patch('/{hall}/toggle-availability', [App\Http\Controllers\Staff\HallController::class, 'toggleAvailability'])->name('halls.toggle-availability');
    });
    
    // Student routes
    Route::prefix('students')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\StudentController::class, 'index'])->name('students.index');
        Route::get('/{student}', [App\Http\Controllers\Staff\StudentController::class, 'show'])->name('students.show');
    });
    
    // Notice routes
    Route::prefix('notices')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\NoticeController::class, 'index'])->name('notices.index');
        Route::get('/{notice}', [App\Http\Controllers\Staff\NoticeController::class, 'show'])->name('notices.show');
    });
});

// Department Head Routes
Route::prefix('department-head')->name('department-head.')->middleware(['auth', 'role:department_head', 'prevent-back'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DepartmentHead\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\DepartmentHead\ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [App\Http\Controllers\DepartmentHead\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [App\Http\Controllers\DepartmentHead\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [App\Http\Controllers\DepartmentHead\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/update-password', [App\Http\Controllers\DepartmentHead\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });
    
    // Course Assignment routes
    Route::prefix('course-assignment')->group(function () {
        Route::get('/', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'index'])->name('course-assignment.index');
        Route::get('/assign/{course}', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'assign'])->name('course-assignment.assign');
        Route::post('/assign/{course}', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'storeAssignment'])->name('course-assignment.store');
        Route::delete('/unassign/{course}', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'unassign'])->name('course-assignment.unassign');
        Route::post('/bulk-assign', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'bulkAssign'])->name('course-assignment.bulk-assign');
        Route::get('/workload-report', [App\Http\Controllers\DepartmentHead\CourseAssignmentController::class, 'workloadReport'])->name('course-assignment.workload-report');
    });
    
    // Notice routes
    Route::prefix('notices')->group(function () {
        Route::get('/', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'index'])->name('notices.index');
        Route::get('/create', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'create'])->name('notices.create');
        Route::post('/', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'store'])->name('notices.store');
        Route::get('/{notice}', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'show'])->name('notices.show');
        Route::get('/{notice}/edit', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'edit'])->name('notices.edit');
        Route::put('/{notice}', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'update'])->name('notices.update');
        Route::delete('/{notice}', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'destroy'])->name('notices.destroy');
        Route::patch('/{notice}/toggle-status', [App\Http\Controllers\DepartmentHead\NoticeController::class, 'toggleStatus'])->name('notices.toggle-status');
    });
});

require __DIR__.'/auth.php';