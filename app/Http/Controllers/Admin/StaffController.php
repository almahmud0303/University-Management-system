<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Staff::with(['user', 'department']);

        // Search by name, email, or employee ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by employment type
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $staff = $query->latest()->paginate(15)->withQueryString();
        $departments = Department::where('is_active', true)->get();

        return view('admin.staff.index', compact('staff', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.staff.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'employee_id' => 'required|string|max:255|unique:staff,employee_id',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
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
            'role' => 'staff',
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'is_active' => true,
        ]);

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->update(['profile_image' => $profileImagePath]);
        }

        // Create staff
        Staff::create([
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

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        $staff->load(['user', 'department']);
        
        $stats = [
            'total_book_issues' => $staff->bookIssues()->count(),
            'active_book_issues' => $staff->bookIssues()->where('status', 'issued')->count(),
            'overdue_books' => $staff->bookIssues()->where('status', 'overdue')->count(),
            'total_halls_managed' => $staff->halls()->count(),
        ];

        $recentBookIssues = $staff->bookIssues()
            ->with(['book', 'student.user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.staff.show', compact('staff', 'stats', 'recentBookIssues'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.staff.edit', compact('staff', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->user_id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'employee_id' => 'required|string|max:255|unique:staff,employee_id,' . $staff->id,
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'required|date',
            'employment_type' => 'required|in:full_time,part_time,contract',
            'is_active' => 'boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'is_active' => $request->has('is_active'),
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $staff->user->update($userData);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($staff->user->profile_image) {
                Storage::disk('public')->delete($staff->user->profile_image);
            }
            
            $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
            $staff->user->update(['profile_image' => $profileImagePath]);
        }

        // Update staff
        $staff->update([
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

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Delete profile image
        if ($staff->user->profile_image) {
            Storage::disk('public')->delete($staff->user->profile_image);
        }

        // Delete user (this will cascade to staff due to foreign key)
        $staff->user->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    /**
     * Toggle the active status of the specified staff member.
     */
    public function toggleStatus(Staff $staff)
    {
        $staff->is_active = !$staff->is_active;
        $staff->save();

        $staff->user->is_active = $staff->is_active;
        $staff->user->save();

        return back()->with('success', 'Staff status updated successfully.');
    }
}