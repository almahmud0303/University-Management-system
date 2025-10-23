<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $teacher->load(['user', 'department', 'courses.department']);

        $stats = [
            'total_courses' => $teacher->courses()->count(),
            'active_courses' => $teacher->courses()->where('is_active', true)->count(),
            'total_students' => $teacher->courses()
                ->withCount(['enrollments' => function($q) {
                    $q->where('status', 'enrolled');
                }])
                ->get()
                ->sum('enrollments_count'),
        ];

        return view('teacher.profile.index', compact('teacher', 'stats'));
    }

    public function edit()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $teacher->load(['user', 'department']);

        return view('teacher.profile.edit', compact('teacher'));
    }

    public function update(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(404, 'Teacher profile not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user information
        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
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

        // Update teacher information
        $teacher->update([
            'qualification' => $request->qualification,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
        ]);

        return redirect()->route('teacher.profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('teacher.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('teacher.profile.index')
            ->with('success', 'Password updated successfully.');
    }
}
