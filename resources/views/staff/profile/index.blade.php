<x-staff-layout>
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
                        <a href="{{ route('staff.profile.edit') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
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
                                @if($staff->profile_image)
                                    <img src="{{ asset('storage/' . $staff->profile_image) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <!-- Basic Info -->
                            <h3 class="text-xl font-medium text-gray-900">{{ $staff->user->name }}</h3>
                            <p class="text-gray-600">{{ $staff->position ?? 'Staff Member' }}</p>
                            <p class="text-sm text-gray-500">{{ $staff->employee_id }}</p>
                            
                            <!-- Quick Actions -->
                            <div class="mt-6 space-y-2">
                                <a href="{{ route('staff.profile.edit') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Edit Profile
                                </a>
                                <a href="{{ route('staff.profile.change-password') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
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
                                        <dd class="text-sm text-gray-900">{{ $staff->user->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->user->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->phone ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->date_of_birth ? $staff->date_of_birth->format('M d, Y') : 'N/A' }}</dd>
                                    </div>
                                    <div class="md:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->address ?? 'N/A' }}</dd>
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
                                        <dd class="text-sm text-gray-900">{{ $staff->employee_id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->position ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->department->name ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Joining Date</dt>
                                        <dd class="text-sm text-gray-900">{{ $staff->joining_date ? $staff->joining_date->format('M d, Y') : 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Activity Statistics</h4>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_book_issues'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Total Issues</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $stats['active_book_issues'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Active Issues</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $stats['returned_books'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Returned</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-red-600">{{ $stats['overdue_books'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-500">Overdue</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
