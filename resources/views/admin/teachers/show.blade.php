<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Teacher Information -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold mb-4">Teacher Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Full Name</label>
                                    <p class="text-gray-900">{{ $teacher->user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Employee ID</label>
                                    <p class="text-gray-900">{{ $teacher->employee_id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Email</label>
                                    <p class="text-gray-900">{{ $teacher->user->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Phone</label>
                                    <p class="text-gray-900">{{ $teacher->phone ?? 'Not provided' }}</p>
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
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Joined Date</label>
                                    <p class="text-gray-900">{{ $teacher->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            @if($teacher->bio)
                                <div class="mt-6">
                                    <label class="text-sm font-medium text-gray-500">Bio</label>
                                    <p class="text-gray-900 mt-1">{{ $teacher->bio }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Edit Teacher
                                </a>
                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                        Delete Teacher
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Courses -->
                    @if($teacher->courses->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Assigned Courses</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($teacher->courses as $course)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900">{{ $course->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $course->course_code }}</p>
                                        <p class="text-sm text-gray-500">{{ $course->department->name }}</p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="text-xs text-gray-500">{{ $course->enrollments()->where('status', 'enrolled')->count() }} students</span>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
