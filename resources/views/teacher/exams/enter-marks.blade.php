<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Enter Marks - {{ $exam->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('teacher.exams.show', $exam->id) }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Assessment
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Exam Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ $exam->title }}</h1>
                            <p class="text-gray-600">{{ $exam->course->title }} • {{ ucfirst($exam->type) }} • {{ $exam->total_marks }} marks</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Students</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $students->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Marks Entry Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Enter Student Marks</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('teacher.exams.store-marks', $exam->id) }}">
                        @csrf
                        
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
                                    @foreach($students as $student)
                                        @php
                                            $result = $results->get($student->id);
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-blue-600">
                                                                {{ substr($student->user->name, 0, 2) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $student->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $student->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $student->student_id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" 
                                                           name="marks[{{ $student->id }}]" 
                                                           value="{{ $result ? $result->marks_obtained : '' }}"
                                                           min="0" 
                                                           max="{{ $exam->total_marks }}"
                                                           class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('marks.' . $student->id) border-red-300 @enderror"
                                                           required>
                                                    <span class="text-sm text-gray-500">/ {{ $exam->total_marks }}</span>
                                                </div>
                                                @error('marks.' . $student->id)
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($result)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800' : 
                                                           ($result->grade === 'A-' || $result->grade === 'B+' || $result->grade === 'B' ? 'bg-blue-100 text-blue-800' : 
                                                           ($result->grade === 'B-' || $result->grade === 'C+' || $result->grade === 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                        {{ $result->grade }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-gray-400">Not graded</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($result)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        {{ $result->is_published ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                        {{ $result->is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                @else
                                                    <span class="text-sm text-gray-400">Not submitted</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('teacher.exams.show', $exam->id) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Save Marks
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grade Scale Reference -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Grade Scale Reference</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <div class="bg-green-100 text-green-800 px-3 py-2 rounded-lg font-semibold">A+</div>
                            <p class="text-xs text-gray-500 mt-1">80-100%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 text-green-800 px-3 py-2 rounded-lg font-semibold">A</div>
                            <p class="text-xs text-gray-500 mt-1">75-79%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-green-100 text-green-800 px-3 py-2 rounded-lg font-semibold">A-</div>
                            <p class="text-xs text-gray-500 mt-1">70-74%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg font-semibold">B+</div>
                            <p class="text-xs text-gray-500 mt-1">65-69%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg font-semibold">B</div>
                            <p class="text-xs text-gray-500 mt-1">60-64%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg font-semibold">B-</div>
                            <p class="text-xs text-gray-500 mt-1">55-59%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-yellow-100 text-yellow-800 px-3 py-2 rounded-lg font-semibold">C+</div>
                            <p class="text-xs text-gray-500 mt-1">50-54%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-yellow-100 text-yellow-800 px-3 py-2 rounded-lg font-semibold">C</div>
                            <p class="text-xs text-gray-500 mt-1">45-49%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-red-100 text-red-800 px-3 py-2 rounded-lg font-semibold">D</div>
                            <p class="text-xs text-gray-500 mt-1">40-44%</p>
                        </div>
                        <div class="text-center">
                            <div class="bg-red-100 text-red-800 px-3 py-2 rounded-lg font-semibold">F</div>
                            <p class="text-xs text-gray-500 mt-1">Below 40%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
