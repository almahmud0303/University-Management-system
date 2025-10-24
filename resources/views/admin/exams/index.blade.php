<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exams') }}
            </h2>
            <a href="{{ route('admin.exams.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Add Exam
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($exams->count() > 0)
                        <div class="space-y-4">
                            @foreach($exams as $exam)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h3>
                                            <p class="text-sm text-gray-600">{{ $exam->course->title }} • {{ ucfirst($exam->type) }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($exam->status ?? 'Scheduled') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-4">
                                        <div>
                                            <span class="font-medium">Date:</span>
                                            {{ $exam->exam_date->format('M d, Y') }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Time:</span>
                                            {{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('h:i A') }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Marks:</span>
                                            {{ $exam->total_marks }}
                                        </div>
                                    </div>
                                    
                                    @if($exam->venue)
                                        <p class="text-sm text-gray-600 mb-4">Venue: {{ $exam->venue }}</p>
                                    @endif
                                    
                                    <div class="flex justify-between items-center text-sm text-gray-500">
                                        <div class="flex space-x-4">
                                            <span>Teacher: {{ $exam->course->teacher->user->name ?? 'Not assigned' }}</span>
                                            <span>Students: {{ $exam->course->enrollments()->where('status', 'enrolled')->count() }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.exams.show', $exam) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('admin.exams.edit', $exam) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this exam?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $exams->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">No exams found.</p>
                            <a href="{{ route('admin.exams.create') }}" 
                               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Add First Exam
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
