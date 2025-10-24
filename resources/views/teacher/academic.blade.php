<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Academic Information') }}
            </h2>
            <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Department Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Department Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Department</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $teacher->department->name ?? 'Not assigned' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Department Code</h4>
                            <p class="mt-1 text-lg text-gray-900">{{ $teacher->department->code ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($teacher->department && $teacher->department->description)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500">Description</h4>
                            <p class="mt-1 text-gray-700">{{ $teacher->department->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Courses Taught -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Courses Taught</h3>
                </div>
                <div class="p-6">
                    @if($teacher->courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($teacher->courses as $course)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $course->course_code }}</p>
                                            <p class="text-xs text-gray-500">{{ $course->department->name }}</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <span>Credits:</span>
                                            <span class="font-medium">{{ $course->credits }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Type:</span>
                                            <span class="font-medium">{{ ucfirst($course->type) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Max Students:</span>
                                            <span class="font-medium">{{ $course->max_students }}</span>
                                        </div>
                                    </div>

                                    @if($course->description)
                                        <div class="mt-3">
                                            <p class="text-xs text-gray-500 line-clamp-2">{{ $course->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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