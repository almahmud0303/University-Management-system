<x-teacher-layout>
    <x-slot name="header">My Profile</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                            <p class="text-gray-600">View and manage your profile details</p>
                        </div>
                        <a href="{{ route('department-head.profile.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <!-- Profile Image -->
                            <div class="mx-auto h-32 w-32 rounded-full overflow-hidden bg-gray-100 mb-4">
                                @if($teacher->profile_image)
                                    <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Basic Info -->
                            <h3 class="text-xl font-medium text-gray-900">{{ $teacher->user->name }}</h3>
                            <p class="text-gray-600">{{ $teacher->position ?? 'Department Head' }}</p>
                            <p class="text-sm text-gray-500">{{ $teacher->employee_id }}</p>
                            
                            <!-- Quick Actions -->
                            <div class="mt-6 space-y-2">
                                <a href="{{ route('department-head.profile.edit') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Edit Profile
                                </a>
                                <a href="{{ route('department-head.profile.change-password') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Personal Information</h4>
                            </div>
                            <div class="p-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->user->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->user->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->phone ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->date_of_birth ? $teacher->date_of_birth->format('M d, Y') : 'N/A' }}</dd>
                                    </div>
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->address ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Professional Information</h4>
                            </div>
                            <div class="p-6">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->employee_id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->position ?? 'Department Head' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->department->name ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Qualification</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->qualification ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Joining Date</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->joining_date ? $teacher->joining_date->format('M d, Y') : 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                                        <dd class="text-sm text-gray-900">{{ $teacher->specialization ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Department Statistics -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Department Statistics</h4>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_courses'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">My Courses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_students'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">My Students</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $stats['department_teachers'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Dept Teachers</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-orange-600">{{ $stats['department_students'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Dept Students</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>
