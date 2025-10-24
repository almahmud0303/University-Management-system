<?php

namespace App\Http\Controllers\DepartmentHead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the department head's profile.
     */
    public function index()
    {
        $teacher = auth()->user()->teacher;
        $teacher->load(['department', 'courses.students']);
        
        // Get statistics
        $stats = [
            'total_courses' => $teacher->courses->count(),
            'total_students' => $teacher->courses->sum(function($course) {
                return $course->students->count();
            }),
            'department_teachers' => $teacher->department->teachers->count(),
            'department_students' => $teacher->department->students->count(),
        ];
        
        return view('department-head.profile.index', compact('teacher', 'stats'));
    }
    
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $teacher = auth()->user()->teacher;
        return view('department-head.profile.edit', compact('teacher'));
    }
    
    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $teacher = auth()->user()->teacher;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'employee_id' => 'required|string|max:50|unique:teachers,employee_id,' . $teacher->id,
            'position' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'specialization' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Update user information
        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // Update teacher information
        $teacherData = $request->only([
            'phone', 'date_of_birth', 'address', 'employee_id',
            'position', 'qualification', 'joining_date', 'specialization'
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $teacherData['profile_image'] = $imagePath;
        }
        
        $teacher->update($teacherData);
        
        return redirect()->route('department-head.profile.index')->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Show the form for changing password.
     */
    public function changePassword()
    {
        return view('department-head.profile.change-password');
    }
    
    /**
     * Update the password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('department-head.profile.index')->with('success', 'Password updated successfully.');
    }
}
