<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Book') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.books.show', $book) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View Book
                </a>
                <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Books
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.books.update', $book) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Book Title and Author -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Book Title *</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700">Author *</label>
                                <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('author') border-red-500 @enderror">
                                @error('author')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- ISBN and Publisher -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN *</label>
                                <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('isbn') border-red-500 @enderror">
                                @error('isbn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="publisher" class="block text-sm font-medium text-gray-700">Publisher</label>
                                <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('publisher') border-red-500 @enderror">
                                @error('publisher')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Category and Publication Year -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                <select id="category" name="category" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('category') border-red-500 @enderror">
                                    <option value="">Select Category</option>
                                    <option value="Fiction" {{ old('category', $book->category) === 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                    <option value="Non-Fiction" {{ old('category', $book->category) === 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                    <option value="Textbook" {{ old('category', $book->category) === 'Textbook' ? 'selected' : '' }}>Textbook</option>
                                    <option value="Reference" {{ old('category', $book->category) === 'Reference' ? 'selected' : '' }}>Reference</option>
                                    <option value="Research" {{ old('category', $book->category) === 'Research' ? 'selected' : '' }}>Research</option>
                                    <option value="Journal" {{ old('category', $book->category) === 'Journal' ? 'selected' : '' }}>Journal</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="publication_year" class="block text-sm font-medium text-gray-700">Publication Year</label>
                                <input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" 
                                       min="1800" max="{{ date('Y') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('publication_year') border-red-500 @enderror">
                                @error('publication_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Copies Information -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="total_copies" class="block text-sm font-medium text-gray-700">Total Copies *</label>
                                <input type="number" id="total_copies" name="total_copies" value="{{ old('total_copies', $book->total_copies) }}" min="1" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('total_copies') border-red-500 @enderror">
                                @error('total_copies')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="available_copies" class="block text-sm font-medium text-gray-700">Available Copies *</label>
                                <input type="number" id="available_copies" name="available_copies" value="{{ old('available_copies', $book->available_copies) }}" min="0" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('available_copies') border-red-500 @enderror">
                                @error('available_copies')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shelf_location" class="block text-sm font-medium text-gray-700">Shelf Location</label>
                                <input type="text" id="shelf_location" name="shelf_location" value="{{ old('shelf_location', $book->shelf_location) }}"
                                       placeholder="e.g., A-1-15"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('shelf_location') border-red-500 @enderror">
                                @error('shelf_location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.books.show', $book) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded">
                                Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
