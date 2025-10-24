<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $student->load(['user', 'department']);

        // Get student statistics
        $stats = [
            'total_courses' => $student->enrollments()->count(),
            'enrolled_courses' => $student->enrollments()->where('status', 'enrolled')->count(),
            'completed_courses' => $student->enrollments()->where('status', 'completed')->count(),
            'issued_books' => $student->bookIssues()->where('status', 'issued')->count(),
        ];

        return view('student.profile.index', compact('student', 'stats'));
    }

    public function edit()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $student->load('user');
        return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user information
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Handle profile image upload
        $profileImagePath = $student->profile_image;
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($student->profile_image) {
                \Storage::disk('public')->delete($student->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $profileImagePath = $file->storeAs('student-profiles', $filename, 'public');
        }

        // Update student information
        $student->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'emergency_contact_name' => $request->emergency_contact_name,
            'profile_image' => $profileImagePath,
        ]);

        return redirect()->route('student.profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        return view('student.profile.change-password', compact('student'));
    }

    public function updatePassword(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            abort(404, 'Student profile not found');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('student.profile.index')
            ->with('success', 'Password changed successfully.');
    }
}
