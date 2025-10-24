<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('teacher.courses.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Courses
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
                            <p class="text-gray-600 mb-4">{{ $course->course_code }} • {{ $course->department->name }}</p>
                            
                            @if($course->description)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $course->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Credits</p>
                                    <p class="text-lg font-semibold">{{ $course->credits }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Type</p>
                                    <p class="text-lg font-semibold">{{ ucfirst($course->type) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Max Students</p>
                                    <p class="text-lg font-semibold">{{ $course->max_students }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p class="text-lg font-semibold {{ $course->is_active ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $course->is_active ? 'Active' : 'Inactive' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Statistics</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Enrollments:</span>
                                        <span class="font-medium">{{ $stats['total_enrollments'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Active Students:</span>
                                        <span class="font-medium">{{ $stats['active_enrollments'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Completed:</span>
                                        <span class="font-medium">{{ $stats['completed_enrollments'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Exams:</span>
                                        <span class="font-medium">{{ $stats['total_exams'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Upcoming:</span>
                                        <span class="font-medium">{{ $stats['upcoming_exams'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('teacher.courses.students', $course->id) }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Manage Students</h3>
                            <p class="text-sm text-gray-500">View and manage enrolled students</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teacher.exams.index', ['course_id' => $course->id]) }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Assessments</h3>
                            <p class="text-sm text-gray-500">Create and manage exams</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teacher.exams.create') }}?course_id={{ $course->id }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Create Assessment</h3>
                            <p class="text-sm text-gray-500">Add new exam or assignment</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Exams -->
            @if($recentExams->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Exams</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentExams as $exam)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $exam->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ ucfirst($exam->type) }} • {{ $exam->total_marks }} marks</p>
                                        <p class="text-xs text-gray-500">{{ $exam->exam_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $exam->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                               ($exam->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                        <a href="{{ route('teacher.exams.show', $exam->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
