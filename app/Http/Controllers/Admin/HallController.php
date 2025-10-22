<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Student;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::withCount('students')
            ->latest()
            ->paginate(15);

        return view('admin.halls.index', compact('halls'));
    }

    public function create()
    {
        return view('admin.halls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:halls,code',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:1000',
            'facilities' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:male,female,mixed',
            'is_available' => 'boolean',
        ]);

        Hall::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'facilities' => $request->facilities ?? [],
            'location' => $request->location,
            'type' => $request->type,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.halls.index')
            ->with('success', 'Hall created successfully.');
    }

    public function show(Hall $hall)
    {
        $hall->load('students.user');
        
        $stats = [
            'total_students' => $hall->students()->count(),
            'available_slots' => $hall->capacity - $hall->students()->count(),
            'occupancy_percentage' => $hall->capacity > 0 ? ($hall->students()->count() / $hall->capacity) * 100 : 0,
        ];

        return view('admin.halls.show', compact('hall', 'stats'));
    }

    public function edit(Hall $hall)
    {
        return view('admin.halls.edit', compact('hall'));
    }

    public function update(Request $request, Hall $hall)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:halls,code,' . $hall->id,
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:1000',
            'facilities' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:male,female,mixed',
            'is_available' => 'boolean',
        ]);

        $hall->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'facilities' => $request->facilities ?? [],
            'location' => $request->location,
            'type' => $request->type,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.halls.index')
            ->with('success', 'Hall updated successfully.');
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();
        return redirect()->route('admin.halls.index')
            ->with('success', 'Hall deleted successfully.');
    }

    public function assignStudent(Request $request, Hall $hall)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::find($request->student_id);
        
        // Check if hall has available slots
        if ($hall->students()->count() >= $hall->capacity) {
            return redirect()->back()
                ->with('error', 'Hall is at full capacity.');
        }

        // Check if student is already assigned to a hall
        if ($student->hall_id) {
            return redirect()->back()
                ->with('error', 'Student is already assigned to a hall.');
        }

        $student->update(['hall_id' => $hall->id]);

        return redirect()->back()
            ->with('success', 'Student assigned to hall successfully.');
    }

    public function removeStudent(Student $student)
    {
        $student->update(['hall_id' => null]);
        
        return redirect()->back()
            ->with('success', 'Student removed from hall successfully.');
    }
}