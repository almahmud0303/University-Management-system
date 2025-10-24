<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analytics Dashboard') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overview Cards -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $analytics['students']['total'] }}</dd>
                                    <dd class="text-sm text-green-600">{{ $analytics['students']['active'] }} active</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Teachers</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $analytics['teachers']['total'] }}</dd>
                                    <dd class="text-sm text-green-600">{{ $analytics['teachers']['active'] }} active</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Courses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $analytics['courses']['total'] }}</dd>
                                    <dd class="text-sm text-green-600">{{ $analytics['courses']['active'] }} active</dd>
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Exams</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $analytics['exams']['total'] }}</dd>
                                    <dd class="text-sm text-blue-600">{{ $analytics['exams']['upcoming'] }} upcoming</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Students by Academic Year -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Students by Academic Year</h3>
                        <div class="space-y-3">
                            @foreach($analytics['students']['by_year'] as $yearData)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ $yearData->academic_year }} Year</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($yearData->count / $analytics['students']['total']) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $yearData->count }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Students by Department -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Students by Department</h3>
                        <div class="space-y-3">
                            @foreach($analytics['students']['by_department'] as $deptData)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ $deptData->department->name ?? 'Unknown' }}</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($deptData->count / $analytics['students']['total']) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $deptData->count }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teachers and Courses by Department -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Teachers by Department -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Teachers by Department</h3>
                        <div class="space-y-3">
                            @foreach($analytics['teachers']['by_department'] as $deptData)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ $deptData->department->name ?? 'Unknown' }}</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ ($deptData->count / $analytics['teachers']['total']) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $deptData->count }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Courses by Department -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Courses by Department</h3>
                        <div class="space-y-3">
                            @foreach($analytics['courses']['by_department'] as $deptData)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">{{ $deptData->department->name ?? 'Unknown' }}</span>
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($deptData->count / $analytics['courses']['total']) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $deptData->count }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Exam Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $analytics['exams']['total'] }}</div>
                            <div class="text-sm text-gray-600">Total Exams</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $analytics['exams']['upcoming'] }}</div>
                            <div class="text-sm text-gray-600">Upcoming Exams</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-600">{{ $analytics['exams']['completed'] }}</div>
                            <div class="text-sm text-gray-600">Completed Exams</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
