<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Result - {{ $result->student->user->name }}
            </h2>
            <a href="{{ route('teacher.results.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Results
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Result Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Student Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Name:</span> {{ $result->student->user->name }}</p>
                                <p><span class="font-medium">Student ID:</span> {{ $result->student->student_id }}</p>
                                <p><span class="font-medium">Email:</span> {{ $result->student->user->email }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Assessment Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Assessment:</span> {{ $result->exam->title }}</p>
                                <p><span class="font-medium">Course:</span> {{ $result->exam->course->title }}</p>
                                <p><span class="font-medium">Type:</span> {{ ucfirst($result->exam->type) }}</p>
                                <p><span class="font-medium">Total Marks:</span> {{ $result->exam->total_marks }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Result</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('teacher.results.update', $result->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Marks Obtained -->
                            <div>
                                <label for="marks_obtained" class="block text-sm font-medium text-gray-700">Marks Obtained *</label>
                                <input type="number" name="marks_obtained" id="marks_obtained" 
                                       value="{{ old('marks_obtained', $result->marks_obtained) }}" 
                                       min="0" max="{{ $result->exam->total_marks }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('marks_obtained') border-red-300 @enderror" 
                                       required>
                                @error('marks_obtained')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Out of {{ $result->exam->total_marks }} marks</p>
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <input type="text" name="remarks" id="remarks" 
                                       value="{{ old('remarks', $result->remarks) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('remarks') border-red-300 @enderror">
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Grade Display -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Current Grade Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Current Grade</p>
                                    <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full 
                                        {{ $result->grade === 'A+' || $result->grade === 'A' ? 'bg-green-100 text-green-800' : 
                                           ($result->grade === 'A-' || $result->grade === 'B+' || $result->grade === 'B' ? 'bg-blue-100 text-blue-800' : 
                                           ($result->grade === 'B-' || $result->grade === 'C+' || $result->grade === 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ $result->grade }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Grade Point</p>
                                    <p class="text-sm font-medium">{{ $result->grade_point }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $result->is_published ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $result->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('teacher.results.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Update Result
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
