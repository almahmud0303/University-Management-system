<x-teacher-layout>
    <x-slot name="header">Assign Course</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Assign Course to Teacher</h3>
                            <p class="text-gray-600">Course: {{ $course->name }} ({{ $course->code }})</p>
                        </div>
                        <a href="{{ route('department-head.course-assignment.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back to Course Assignment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Course Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Course Name</dt>
                            <dd class="text-sm text-gray-900">{{ $course->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Course Code</dt>
                            <dd class="text-sm text-gray-900">{{ $course->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Credits</dt>
                            <dd class="text-sm text-gray-900">{{ $course->credits }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Semester</dt>
                            <dd class="text-sm text-gray-900">{{ $course->semester }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Academic Year</dt>
                            <dd class="text-sm text-gray-900">{{ $course->academic_year }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Current Enrollment</dt>
                            <dd class="text-sm text-gray-900">{{ $course->students->count() }} students</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('department-head.course-assignment.assign', $course) }}" class="p-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Teacher Selection -->
                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700">Select Teacher <span class="text-red-500">*</span></label>
                            <select name="teacher_id" id="teacher_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('teacher_id') border-red-300 @enderror">
                                <option value="">Choose a teacher</option>
                                @foreach($availableTeachers ?? [] as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }} 
                                        @if($teacher->position)
                                            - {{ $teacher->position }}
                                        @endif
                                        ({{ $teacher->courses->count() }} courses)
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if(isset($availableTeachers) && $availableTeachers->isEmpty())
                                <p class="mt-1 text-sm text-yellow-600">No available teachers found for this assignment.</p>
                            @endif
                        </div>

                        <!-- Assignment Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Assignment Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Optional notes about this assignment...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Assignment Date -->
                        <div>
                            <label for="assigned_date" class="block text-sm font-medium text-gray-700">Assignment Date</label>
                            <input type="date" name="assigned_date" id="assigned_date" value="{{ old('assigned_date', now()->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('department-head.course-assignment.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Assign Course
                        </button>
                    </div>
                </form>
            </div>

            <!-- Current Assignment Info -->
            @if($course->teacher)
                <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h4 class="text-lg font-medium text-blue-900 mb-2">Currently Assigned To</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-900 font-medium">{{ $course->teacher->user->name }}</p>
                                <p class="text-blue-700 text-sm">{{ $course->teacher->position ?? 'Teacher' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-blue-700 text-sm">Assigned: {{ $course->updated_at->format('M d, Y') }}</p>
                                <form method="POST" action="{{ route('department-head.course-assignment.unassign', $course) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Are you sure you want to unassign this course?')">
                                        Unassign
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-teacher-layout>
