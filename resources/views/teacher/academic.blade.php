<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academic Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Teacher Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Teacher Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Name</label>
                                    <p class="text-gray-900">{{ $teacher->user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Employee ID</label>
                                    <p class="text-gray-900">{{ $teacher->employee_id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Department</label>
                                    <p class="text-gray-900">{{ $teacher->department->name ?? 'Not assigned' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Qualification</label>
                                    <p class="text-gray-900">{{ $teacher->qualification ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Specialization</label>
                                    <p class="text-gray-900">{{ $teacher->specialization ?? 'Not specified' }}</p>
                                </div>
                                @if($teacher->bio)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Bio</label>
                                        <p class="text-gray-900">{{ $teacher->bio }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Course Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Course Information</h3>
                            @if($teacher->courses->count() > 0)
                                <div class="space-y-3">
                                    @foreach($teacher->courses as $course)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <h4 class="font-medium text-gray-900">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $course->course_code }}</p>
                                            <p class="text-sm text-gray-500">{{ $course->department->name }}</p>
                                            <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                                <span>{{ $course->enrollments()->where('status', 'enrolled')->count() }} students</span>
                                                <span>{{ $course->exams()->count() }} exams</span>
                                                <span class="inline-flex px-2 py-1 rounded-full {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No courses assigned yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
