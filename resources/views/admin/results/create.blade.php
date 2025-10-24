<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.results.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Exam Selection -->
                            <div>
                                <label for="exam_id" class="block text-sm font-medium text-gray-700">Exam <span class="text-red-500">*</span></label>
                                <select name="exam_id" id="exam_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('exam_id') border-red-300 @enderror">
                                    <option value="">Select an exam</option>
                                    @foreach($exams ?? [] as $exam)
                                        <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                            {{ $exam->title }} - {{ $exam->course->title }} ({{ $exam->total_marks }} marks)
                                        </option>
                                    @endforeach
                                </select>
                                @error('exam_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Student Selection -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student <span class="text-red-500">*</span></label>
                                <select name="student_id" id="student_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('student_id') border-red-300 @enderror">
                                    <option value="">Select a student</option>
                                    @foreach($students ?? [] as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }} ({{ $student->student_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Marks -->
                            <div>
                                <label for="marks" class="block text-sm font-medium text-gray-700">Marks Obtained <span class="text-red-500">*</span></label>
                                <input type="number" name="marks" id="marks" step="0.01" min="0" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('marks') border-red-300 @enderror" value="{{ old('marks') }}">
                                @error('marks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('remarks') border-red-300 @enderror">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Publish Status -->
                        <div class="mt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-700">
                                    Publish this result immediately
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.results.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Create Result
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
