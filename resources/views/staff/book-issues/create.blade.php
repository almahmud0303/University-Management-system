<x-staff-layout>
    <x-slot name="header">Issue New Book</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staff.book-issues.store') }}" class="space-y-6">
                    @csrf

                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Student *</label>
                        <select id="student_id" name="student_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('student_id') border-red-500 @enderror">
                            <option value="">Select Student</option>
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

                    <!-- Book Selection -->
                    <div>
                        <label for="book_id" class="block text-sm font-medium text-gray-700">Book *</label>
                        <select id="book_id" name="book_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('book_id') border-red-500 @enderror">
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}
                                        {{ $book->available_copies <= 0 ? 'disabled' : '' }}>
                                    {{ $book->title }} by {{ $book->author }}
                                    @if($book->available_copies <= 0)
                                        (Unavailable)
                                    @else
                                        ({{ $book->available_copies }} available)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue Date and Due Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date *</label>
                            <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('issue_date') border-red-500 @enderror">
                            @error('issue_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date *</label>
                            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('due_date') border-red-500 @enderror">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('staff.book-issues.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                            Issue Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staff-layout>
