<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Assessments') }}
            </h2>
            <a href="{{ route('teacher.exams.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Create Assessment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm mb-6">
                <div class="p-6">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Filter by Course</label>
                            <select name="course_id" id="course_id" 
                                    class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Filter by Type</label>
                            <select name="type" id="type" 
                                    class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="midterm" {{ request('type') == 'midterm' ? 'selected' : '' }}>Midterm</option>
                                <option value="assignment" {{ request('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Exams List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($exams->count() > 0)
                        <div class="space-y-4">
                            @foreach($exams as $exam)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $exam->course->title }} • {{ ucfirst($exam->type) }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $exam->exam_date->format('M d, Y') }} at 
                                                {{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }} - 
                                                {{ \Carbon\Carbon::parse($exam->end_time)->format('h:i A') }}
                                            </p>
                                            @if($exam->venue)
                                                <p class="text-sm text-gray-500">Venue: {{ $exam->venue }}</p>
                                            @endif
                                            <p class="text-sm text-gray-500">Total Marks: {{ $exam->total_marks }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($exam->status ?? 'Scheduled') }}
                                            </span>
                                            <div class="flex space-x-1">
                                                <a href="{{ route('teacher.exams.show', $exam) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                                <a href="{{ route('teacher.exams.edit', $exam) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                                <a href="{{ route('teacher.exams.enter-marks', $exam) }}" 
                                                   class="text-green-600 hover:text-green-900 text-sm">Enter Marks</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $exams->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">No assessments found.</p>
                            <a href="{{ route('teacher.exams.create') }}" 
                               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Create Your First Assessment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
