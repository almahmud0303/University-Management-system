<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Result Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Result Details</h3>
                            <p class="text-gray-600">Examination result information</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.results.edit', $result) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Edit Result
                            </a>
                            <a href="{{ route('admin.results.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Back to Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Student Information</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Student Name</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->student->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->student->student_id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->student->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->student->department->name ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Exam Information -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Exam Information</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Course</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->exam->course->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Course Code</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->exam->course->course_code }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Exam Title</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->exam->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Marks</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->exam->total_marks }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Exam Date</dt>
                                    <dd class="text-sm text-gray-900">{{ $result->exam->exam_date ? $result->exam->exam_date->format('M d, Y') : 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Result Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $result->marks_obtained }}</div>
                            <div class="text-sm text-blue-800">Marks Obtained</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $result->grade }}</div>
                            <div class="text-sm text-green-800">Grade</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">{{ $result->grade_point }}</div>
                            <div class="text-sm text-purple-800">Grade Point</div>
                        </div>
                    </div>

                    @if($result->remarks)
                        <div class="mt-6">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Remarks</h5>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $result->remarks }}</p>
                        </div>
                    @endif

                    <!-- Status -->
                    <div class="mt-6 flex items-center justify-between">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $result->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $result->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Created: {{ $result->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Actions</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.results.edit', $result) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit Result
                        </a>
                        
                        <form method="POST" action="{{ route('admin.results.destroy', $result) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this result? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Delete Result
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
