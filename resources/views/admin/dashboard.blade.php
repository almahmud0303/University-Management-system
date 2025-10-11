<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Admin Dashboard</h2>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-500">Total Students</div>
                                <div class="text-3xl font-bold text-blue-600">{{ $stats['total_students'] }}</div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Active: {{ $stats['active_students'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Teachers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-500">Total Teachers</div>
                                <div class="text-3xl font-bold text-green-600">{{ $stats['total_teachers'] }}</div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Active: {{ $stats['active_teachers'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Staff -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-500">Total Staff</div>
                                <div class="text-3xl font-bold text-purple-600">{{ $stats['total_staff'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-500">Total Courses</div>
                                <div class="text-3xl font-bold text-orange-600">{{ $stats['total_courses'] }}</div>
                                <div class="text-sm text-gray-600 mt-1">
                                    Active: {{ $stats['active_courses'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.students.create') }}" 
                           class="bg-blue-600 text-white px-4 py-3 rounded text-center hover:bg-blue-700">
                            Add New Student
                        </a>
                        <a href="{{ route('admin.teachers.create') }}" 
                           class="bg-green-600 text-white px-4 py-3 rounded text-center hover:bg-green-700">
                            Add New Teacher
                        </a>
                        <a href="{{ route('admin.staff.create') }}" 
                           class="bg-purple-600 text-white px-4 py-3 rounded text-center hover:bg-purple-700">
                            Add New Staff
                        </a>
                        <a href="{{ route('admin.departments.create') }}" 
                           class="bg-orange-600 text-white px-4 py-3 rounded text-center hover:bg-orange-700">
                            Add New Department
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Students -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4">Recent Students</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentStudents as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $student->student_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $student->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $student->user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $student->department->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.students.show', $student) }}" 
                                           class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>