<x-teacher-layout>
    <x-slot name="header">Department Head Dashboard</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Welcome back, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600">
                        Department: {{ Auth::user()->teacher->department->name ?? 'N/A' }} | 
                        Role: Department Head
                    </p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Department Teachers</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $departmentTeachers->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Department Courses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $departmentCourses->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Department Students</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $departmentStudents->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Unassigned Courses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $unassignedCourses->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('department-head.course-assignment.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Course Assignment</h3>
                        <p class="mt-2 text-sm text-gray-500">Assign courses to teachers and manage workloads</p>
                        <div class="mt-4 text-blue-600 font-medium">Manage →</div>
                    </div>
                </a>

                <a href="{{ route('department-head.notices.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 group-hover:bg-green-200 transition-colors">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7l-1.758-1.758a2 2 0 00-2.828 0L4.828 7z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Department Notices</h3>
                        <p class="mt-2 text-sm text-gray-500">Create and manage department-specific notices</p>
                        <div class="mt-4 text-green-600 font-medium">Manage →</div>
                    </div>
                </a>

                <a href="{{ route('department-head.workload-report') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 group-hover:bg-purple-200 transition-colors">
                            <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Workload Report</h3>
                        <p class="mt-2 text-sm text-gray-500">View teacher workload distribution and reports</p>
                        <div class="mt-4 text-purple-600 font-medium">View →</div>
                    </div>
                </a>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Teachers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Department Teachers</h3>
                        <div class="space-y-3">
                            @forelse($departmentTeachers ?? [] as $teacher)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $teacher->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $teacher->position ?? 'Teacher' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">{{ $teacher->courses->count() ?? 0 }} courses</p>
                                        <p class="text-xs text-gray-500">{{ $teacher->user->email }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No teachers found in this department.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Students</h3>
                        <div class="space-y-3">
                            @forelse($recentStudents ?? [] as $student)
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $student->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $student->student_id }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">{{ $student->academic_year ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->semester ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No recent students found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>