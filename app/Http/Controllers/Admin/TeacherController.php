<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'department'])
            ->latest()
            ->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.teachers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'employee_id' => 'required|string|max:255|unique:teachers',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->update(['profile_image' => $profileImagePath]);
        }

        // Create teacher
        Teacher::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'designation' => $request->designation,
            'qualification' => $request->qualification,
            'specialization' => $request->specialization,
            'salary' => $request->salary,
            'joining_date' => $request->joining_date,
            'employment_type' => $request->employment_type,
            'is_active' => true,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'department', 'courses']);
        
        $stats = [
            'total_courses' => $teacher->courses()->count(),
            'active_courses' => $teacher->courses()->where('is_active', true)->count(),
            'total_students' => $teacher->courses()->withCount('enrollments')->get()->sum('enrollments_count'),
        ];

        $recentCourses = $teacher->courses()
            ->with('department')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.teachers.show', compact('teacher', 'stats', 'recentCourses'));
    }

    public function edit(Teacher $teacher)
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.teachers.edit', compact('teacher', 'departments'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'employee_id' => 'required|string|max:255|unique:teachers,employee_id,' . $teacher->id,
            'department_id' => 'required|exists:departments,id',
            'designation' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'is_active' => 'boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user
        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($teacher->user->profile_image) {
                Storage::disk('public')->delete($teacher->user->profile_image);
            }
            
            $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
            $teacher->user->update(['profile_image' => $profileImagePath]);
        }

        // Update teacher
        $teacher->update([
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'designation' => $request->designation,
            'qualification' => $request->qualification,
            'specialization' => $request->specialization,
            'salary' => $request->salary,
            'joining_date' => $request->joining_date,
            'employment_type' => $request->employment_type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        // Delete profile image
        if ($teacher->user->profile_image) {
            Storage::disk('public')->delete($teacher->user->profile_image);
        }

        // Delete user (this will cascade to teacher due to foreign key)
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    public function credentials(Teacher $teacher)
    {
        return view('admin.teachers.credentials', compact('teacher'));
    }
}