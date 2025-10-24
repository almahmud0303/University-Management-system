<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Fee Record') }} - {{ $fee->fee_type }}
            </h2>
            <a href="{{ route('admin.fees.show', $fee->id) }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Fee Record
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.fees.update', $fee->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student *</label>
                                <select name="student_id" id="student_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('student_id') border-red-300 @enderror" 
                                        required>
                                    <option value="">Select a student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id', $fee->student_id) == $student->id ? 'selected' : '' }}>
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
                                    <option value="tuition" {{ old('fee_type', $fee->fee_type) == 'tuition' ? 'selected' : '' }}>Tuition Fee</option>
                                    <option value="registration" {{ old('fee_type', $fee->fee_type) == 'registration' ? 'selected' : '' }}>Registration Fee</option>
                                    <option value="library" {{ old('fee_type', $fee->fee_type) == 'library' ? 'selected' : '' }}>Library Fee</option>
                                    <option value="laboratory" {{ old('fee_type', $fee->fee_type) == 'laboratory' ? 'selected' : '' }}>Laboratory Fee</option>
                                    <option value="examination" {{ old('fee_type', $fee->fee_type) == 'examination' ? 'selected' : '' }}>Examination Fee</option>
                                    <option value="transport" {{ old('fee_type', $fee->fee_type) == 'transport' ? 'selected' : '' }}>Transport Fee</option>
                                    <option value="hostel" {{ old('fee_type', $fee->fee_type) == 'hostel' ? 'selected' : '' }}>Hostel Fee</option>
                                    <option value="other" {{ old('fee_type', $fee->fee_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('fee_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Total Amount *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount', $fee->amount) }}" 
                                           min="0" step="0.01"
                                           class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-300 @enderror" 
                                           required>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Paid Amount -->
                            <div>
                                <label for="paid_amount" class="block text-sm font-medium text-gray-700">Paid Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="paid_amount" id="paid_amount" value="{{ old('paid_amount', $fee->paid_amount) }}" 
                                           min="0" step="0.01" max="{{ $fee->amount }}"
                                           class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('paid_amount') border-red-300 @enderror">
                                </div>
                                @error('paid_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $fee->due_date->format('Y-m-d')) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('due_date') border-red-300 @enderror" 
                                       required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Paid Date -->
                            <div>
                                <label for="paid_date" class="block text-sm font-medium text-gray-700">Paid Date</label>
                                <input type="date" name="paid_date" id="paid_date" value="{{ old('paid_date', $fee->paid_date ? $fee->paid_date->format('Y-m-d') : '') }}" 
                                       max="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('paid_date') border-red-300 @enderror">
                                @error('paid_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-300 @enderror" 
                                        required>
                                    <option value="">Select status</option>
                                    <option value="pending" {{ old('status', $fee->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="partial" {{ old('status', $fee->status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ old('status', $fee->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ old('status', $fee->status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-300 @enderror">{{ old('notes', $fee->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.fees.show', $fee->id) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Update Fee Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
