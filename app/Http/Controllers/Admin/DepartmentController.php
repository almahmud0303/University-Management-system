<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('head')
            ->withCount(['students', 'teachers', 'courses'])
            ->latest()
            ->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $heads = User::where('role', 'teacher')
            ->whereDoesntHave('teacher.department')
            ->get();

        return view('admin.departments.create', compact('heads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'head_user_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        Department::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'head_of_department' => $request->head_of_department,
            'head_user_id' => $request->head_user_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load(['head', 'students.user', 'teachers.user', 'courses.teacher.user']);

        $stats = [
            'total_students' => $department->students()->count(),
            'total_teachers' => $department->teachers()->count(),
            'total_courses' => $department->courses()->count(),
            'active_students' => $department->students()->active()->count(),
            'active_teachers' => $department->teachers()->active()->count(),
        ];

        return view('admin.departments.show', compact('department', 'stats'));
    }

    public function edit(Department $department)
    {
        $heads = User::where('role', 'teacher')->get();
        return view('admin.departments.edit', compact('department', 'heads'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
            'head_user_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        $department->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'head_of_department' => $request->head_of_department,
            'head_user_id' => $request->head_user_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function toggleStatus(Department $department)
    {
        $department->is_active = !$department->is_active;
        $department->save();

        return back()->with('success', 'Department status updated successfully.');
    }
}