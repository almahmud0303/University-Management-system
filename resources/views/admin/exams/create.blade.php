<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Exam') }}
            </h2>
            <a href="{{ route('admin.exams.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Exams
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.exams.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Exam Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Exam Information</h3>
                                
                                <div>
                                    <x-input-label for="title" :value="__('Exam Title')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g., Midterm Exam, Final Exam" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="course_id" :value="__('Course')" />
                                    <select id="course_id" name="course_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Select Course</option>
                                        @foreach(\App\Models\Course::where('is_active', true)->with('department')->get() as $course)
                                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }} - {{ $course->department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="type" :value="__('Exam Type')" />
                                    <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">Select Type</option>
                                        <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                        <option value="midterm" {{ old('type') == 'midterm' ? 'selected' : '' }}>Midterm</option>
                                        <option value="final" {{ old('type') == 'final' ? 'selected' : '' }}>Final</option>
                                        <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                        <option value="project" {{ old('type') == 'project' ? 'selected' : '' }}>Project</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Exam description or instructions">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Schedule & Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Schedule & Details</h3>
                                
                                <div>
                                    <x-input-label for="exam_date" :value="__('Exam Date')" />
                                    <x-text-input id="exam_date" class="block mt-1 w-full" type="date" name="exam_date" :value="old('exam_date')" required />
                                    <x-input-error :messages="$errors->get('exam_date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="start_time" :value="__('Start Time')" />
                                    <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="end_time" :value="__('End Time')" />
                                    <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="total_marks" :value="__('Total Marks')" />
                                    <x-text-input id="total_marks" class="block mt-1 w-full" type="number" name="total_marks" :value="old('total_marks')" required min="1" step="0.01" />
                                    <x-input-error :messages="$errors->get('total_marks')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="passing_marks" :value="__('Passing Marks')" />
                                    <x-text-input id="passing_marks" class="block mt-1 w-full" type="number" name="passing_marks" :value="old('passing_marks')" min="0" step="0.01" />
                                    <x-input-error :messages="$errors->get('passing_marks')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="location" :value="__('Location')" />
                                    <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="e.g., Room 101, Lab A" />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status</h3>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="is_published" class="ml-2 text-sm text-gray-700">
                                    Publish Exam (make it visible to students)
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.exams.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Exam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
