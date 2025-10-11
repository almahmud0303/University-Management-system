<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Department, User};
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('head')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.departments.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string',
            'head_user_id' => 'nullable|exists:users,id',
        ]);

        Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('head', 'teachers', 'students', 'courses');

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $teachers = User::where('role', 'teacher')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.departments.edit', compact('department', 'teachers'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'head_user_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}