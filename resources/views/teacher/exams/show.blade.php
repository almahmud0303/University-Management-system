<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $exam->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('teacher.exams.edit', $exam->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Assessment
                </a>
                <a href="{{ route('teacher.exams.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Assessments
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Exam Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $exam->title }}</h1>
                            <p class="text-gray-600 mb-4">{{ $exam->course->title }} • {{ $exam->course->course_code }}</p>
                            
                            @if($exam->description)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $exam->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Type</p>
                                    <p class="text-lg font-semibold">{{ ucfirst($exam->type) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Date</p>
                                    <p class="text-lg font-semibold">{{ $exam->exam_date->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Time</p>
                                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('h:i A') }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Marks</p>
                                    <p class="text-lg font-semibold">{{ $exam->total_marks }}</p>
                                </div>
                            </div>

                            @if($exam->venue)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Venue</h3>
                                    <p class="text-gray-600">{{ $exam->venue }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assessment Statistics</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Students:</span>
                                        <span class="font-medium">{{ $stats['total_students'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Average Marks:</span>
                                        <span class="font-medium">{{ number_format($stats['average_marks'], 1) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Highest Marks:</span>
                                        <span class="font-medium">{{ $stats['highest_marks'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Lowest Marks:</span>
                                        <span class="font-medium">{{ $stats['lowest_marks'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $exam->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                       ($exam->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($exam->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                    Status: {{ ucfirst($exam->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('teacher.exams.enter-marks', $exam->id) }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Enter Marks</h3>
                            <p class="text-sm text-gray-500">Grade student submissions</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teacher.results.index', ['exam_id' => $exam->id]) }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">View Results</h3>
                            <p class="text-sm text-gray-500">Review all student results</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teacher.courses.show', $exam->course->id) }}" 
                   class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Course Details</h3>
                            <p class="text-sm text-gray-500">View course information</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Results -->
            @if($exam->results->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Student Results</h3>
                        <a href="{{ route('teacher.exams.enter-marks', $exam->id) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Enter/Edit Marks
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Marks Obtained
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grade
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grade Point
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($exam->results as $result)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600">
                                                            {{ substr($result->student->user->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $result->student->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $result->student->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $result->student->student_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $result->marks_obtained }}/{{ $exam->total_marks }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800' : 
                                                   ($result->grade === 'A-' || $result->grade === 'B+' || $result->grade === 'B' ? 'bg-blue-100 text-blue-800' : 
                                                   ($result->grade === 'B-' || $result->grade === 'C+' || $result->grade === 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ $result->grade }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $result->grade_point }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $result->is_published ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                {{ $result->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Results Yet</h3>
                        <p class="text-gray-500 mb-4">No student results have been entered for this assessment.</p>
                        <a href="{{ route('teacher.exams.enter-marks', $exam->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Enter Marks
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
