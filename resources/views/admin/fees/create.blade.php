<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Fee Record') }}
            </h2>
            <a href="{{ route('admin.fees.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Fees
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.fees.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student *</label>
                                <select name="student_id" id="student_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('student_id') border-red-300 @enderror" 
                                        required>
                                    <option value="">Select a student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }} ({{ $student->student_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fee Type -->
                            <div>
                                <label for="fee_type" class="block text-sm font-medium text-gray-700">Fee Type *</label>
                                <select name="fee_type" id="fee_type" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fee_type') border-red-300 @enderror" 
                                        required>
                                    <option value="">Select fee type</option>
                                    <option value="tuition" {{ old('fee_type') == 'tuition' ? 'selected' : '' }}>Tuition Fee</option>
                                    <option value="registration" {{ old('fee_type') == 'registration' ? 'selected' : '' }}>Registration Fee</option>
                                    <option value="library" {{ old('fee_type') == 'library' ? 'selected' : '' }}>Library Fee</option>
                                    <option value="laboratory" {{ old('fee_type') == 'laboratory' ? 'selected' : '' }}>Laboratory Fee</option>
                                    <option value="examination" {{ old('fee_type') == 'examination' ? 'selected' : '' }}>Examination Fee</option>
                                    <option value="transport" {{ old('fee_type') == 'transport' ? 'selected' : '' }}>Transport Fee</option>
                                    <option value="hostel" {{ old('fee_type') == 'hostel' ? 'selected' : '' }}>Hostel Fee</option>
                                    <option value="other" {{ old('fee_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('fee_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" 
                                           min="0" step="0.01"
                                           class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-300 @enderror" 
                                           required>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" 
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('due_date') border-red-300 @enderror" 
                                       required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.fees.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Create Fee Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
