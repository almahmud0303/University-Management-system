<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $student->user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.students.edit', $student->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Student
                </a>
                <a href="{{ route('admin.students.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Students
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Student Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <div class="h-16 w-16 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-xl font-medium text-green-600">
                                            {{ substr($student->user->name, 0, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $student->user->name }}</h1>
                                    <p class="text-gray-600">{{ $student->student_id }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->department->name ?? 'No Department' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Roll Number</p>
                                    <p class="text-sm font-semibold">{{ $student->roll_number ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Registration</p>
                                    <p class="text-sm font-semibold">{{ $student->registration_number ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Session</p>
                                    <p class="text-sm font-semibold">{{ $student->session ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Semester</p>
                                    <p class="text-sm font-semibold">{{ $student->semester ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Academic Information</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Academic Year:</span>
                                            <span class="text-sm font-medium">{{ $student->academic_year ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Admission Date:</span>
                                            <span class="text-sm font-medium">{{ $student->admission_date ? $student->admission_date->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">CGPA:</span>
                                            <span class="text-sm font-medium">{{ $student->cgpa ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Credits:</span>
                                            <span class="text-sm font-medium">{{ $student->completed_credits ?? 0 }}/{{ $student->total_credits ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Personal Information</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Blood Group:</span>
                                            <span class="text-sm font-medium">{{ $student->blood_group ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Hall:</span>
                                            <span class="text-sm font-medium">{{ $student->hall->name ?? 'Not Assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Guardian:</span>
                                            <span class="text-sm font-medium">{{ $student->guardian_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Guardian Phone:</span>
                                            <span class="text-sm font-medium">{{ $student->guardian_phone ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $student->user->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Student ID</p>
                                        <p class="font-medium">{{ $student->student_id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($student->status === 'graduated' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($student->status ?? 'Unknown') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Records -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Enrolled Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Enrolled Courses</h3>
                    </div>
                    <div class="p-6">
                        @if($student->courses->count() > 0)
                            <div class="space-y-3">
                                @foreach($student->courses->take(5) as $course)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $course->title }}</p>
                                            <p class="text-sm text-gray-600">{{ $course->course_code }}</p>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $course->credits }} credits</span>
                                    </div>
                                @endforeach
                                @if($student->courses->count() > 5)
                                    <p class="text-sm text-gray-500 text-center">And {{ $student->courses->count() - 5 }} more courses...</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No courses enrolled</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Results -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Results</h3>
                    </div>
                    <div class="p-6">
                        @if($student->results->count() > 0)
                            <div class="space-y-3">
                                @foreach($student->results->take(5) as $result)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $result->exam->title }}</p>
                                            <p class="text-sm text-gray-600">{{ $result->exam->course->title }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium">{{ $result->marks_obtained }}/{{ $result->exam->total_marks }}</p>
                                            <p class="text-sm text-gray-600">{{ $result->grade ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if($student->results->count() > 5)
                                    <p class="text-sm text-gray-500 text-center">And {{ $student->results->count() - 5 }} more results...</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No results available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Financial Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Total Fees</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($student->fees->sum('amount'), 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Paid Amount</p>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($student->payments->sum('amount'), 2) }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Due Amount</p>
                            <p class="text-2xl font-bold text-red-600">${{ number_format($student->fees->sum('amount') - $student->payments->sum('amount'), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
