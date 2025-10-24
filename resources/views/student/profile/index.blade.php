<x-student-layout>
    <x-slot name="header">My Profile</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Information -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Student Avatar -->
                        <div class="flex-shrink-0">
                            <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center">
                                @if($student->user->profile_photo_path)
                                    <img src="{{ Storage::url($student->user->profile_photo_path) }}" alt="{{ $student->user->name }}" class="h-20 w-20 rounded-full object-cover">
                                @else
                                    <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $student->user->name }}</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Student ID:</span> {{ $student->student_id }}
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span> {{ $student->user->email }}
                                </div>
                                <div>
                                    <span class="font-medium">Phone:</span> {{ $student->user->phone ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Department:</span> {{ $student->department->name ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Academic Year:</span> {{ $student->academic_year ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Semester:</span> {{ $student->semester ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Date of Birth:</span> {{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Gender:</span> {{ ucfirst($student->gender ?? 'N/A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if($student->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif($student->status === 'inactive')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @elseif($student->status === 'graduated')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Graduated
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($student->status ?? 'Unknown') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($student->address)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Address</h3>
                            <p class="text-gray-600">{{ $student->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Academic Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Enrolled Courses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->enrollments->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Credits</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->completed_credits ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">CGPA</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $gpa ?? 'N/A' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Books Borrowed</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->bookIssues->where('status', 'issued')->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Actions</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('student.profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Profile
                        </a>
                        <a href="{{ route('student.profile.change-password') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Change Password
                        </a>
                        <a href="{{ route('student.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
