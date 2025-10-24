<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $exam->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.exams.edit', $exam->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Exam
                </a>
                <a href="{{ route('admin.exams.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Exams
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
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Exam Statistics</h3>
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

                            @if($exam->course->teacher)
                                <div class="mt-4 bg-green-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Course Teacher</h3>
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">
                                                    {{ substr($exam->course->teacher->user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $exam->course->teacher->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $exam->course->teacher->employee_id }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Distribution -->
            @if($gradeDistribution->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Grade Distribution</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @foreach(['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'F'] as $grade)
                                <div class="text-center">
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="text-2xl font-bold text-gray-900">{{ $gradeDistribution->get($grade, 0) }}</div>
                                        <div class="text-sm text-gray-500">{{ $grade }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Results -->
            @if($recentResults->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Results</h3>
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
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentResults as $result)
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
                        <p class="text-gray-500">No student results have been entered for this exam.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
