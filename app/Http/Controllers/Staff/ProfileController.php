<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the staff's profile.
     */
    public function index()
    {
        $staff = auth()->user()->staff;
        $staff->load(['department']);
        
        // Get statistics
        $stats = [
            'total_book_issues' => \App\Models\BookIssue::where('staff_id', $staff->id)->count(),
            'active_book_issues' => \App\Models\BookIssue::where('staff_id', $staff->id)->where('status', 'issued')->count(),
            'returned_books' => \App\Models\BookIssue::where('staff_id', $staff->id)->where('status', 'returned')->count(),
            'overdue_books' => \App\Models\BookIssue::where('staff_id', $staff->id)->where('status', 'overdue')->count(),
        ];
        
        return view('staff.profile.index', compact('staff', 'stats'));
    }
    
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $staff = auth()->user()->staff;
        return view('staff.profile.edit', compact('staff'));
    }
    
    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $staff = auth()->user()->staff;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'employee_id' => 'required|string|max:50|unique:staff,employee_id,' . $staff->id,
            'position' => 'nullable|string|max:100',
            'joining_date' => 'nullable|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Update user information
        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // Update staff information
        $staffData = $request->only([
            'phone', 'date_of_birth', 'address', 'employee_id',
            'position', 'joining_date'
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $staffData['profile_image'] = $imagePath;
        }
        
        $staff->update($staffData);
        
        return redirect()->route('staff.profile.index')->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Show the form for changing password.
     */
    public function changePassword()
    {
        return view('staff.profile.change-password');
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
        
        return redirect()->route('staff.profile.index')->with('success', 'Password updated successfully.');
    }
}