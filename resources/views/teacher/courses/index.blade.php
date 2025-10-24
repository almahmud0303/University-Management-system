<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Courses') }}
            </h2>
            <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($courses as $course)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $course->course_code }}</p>
                                            <p class="text-xs text-gray-500">{{ $course->department->name }}</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                            <span>Students Enrolled:</span>
                                            <span class="font-medium">{{ $course->enrollments_count }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                            <span>Max Students:</span>
                                            <span class="font-medium">{{ $course->max_students }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                            <span>Credits:</span>
                                            <span class="font-medium">{{ $course->credits }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm text-gray-600">
                                            <span>Type:</span>
                                            <span class="font-medium">{{ ucfirst($course->type) }}</span>
                                        </div>
                                    </div>

                                    @if($course->description)
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>
                                    @endif

                                    <div class="flex space-x-2">
                                        <a href="{{ route('teacher.courses.show', $course->id) }}" 
                                           class="flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded text-sm text-center hover:bg-blue-100 transition-colors">
                                            View Details
                                        </a>
                                        <a href="{{ route('teacher.courses.students', $course->id) }}" 
                                           class="flex-1 bg-green-50 text-green-600 px-3 py-2 rounded text-sm text-center hover:bg-green-100 transition-colors">
                                            Students
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Courses Assigned</h3>
                            <p class="text-gray-500">You don't have any courses assigned to you yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
