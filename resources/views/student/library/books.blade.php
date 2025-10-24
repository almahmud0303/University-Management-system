<x-student-layout>
    <x-slot name="header">Available Books</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Library Books</h3>
                            <p class="text-gray-600">Browse and search available books in the library</p>
                        </div>
                        <a href="{{ route('student.library.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            My Library
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by title, author, or ISBN..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Books Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books ?? [] as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <!-- Book Cover Placeholder -->
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            
                            <!-- Book Information -->
                            <div class="space-y-2">
                                <h3 class="text-lg font-medium text-gray-900 line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600">by {{ $book->author }}</p>
                                
                                @if($book->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $book->category }}
                                    </span>
                                @endif
                                
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>ISBN: {{ $book->isbn }}</span>
                                    <span>{{ $book->available_copies }} available</span>
                                </div>
                                
                                @if($book->description)
                                    <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit($book->description, 100) }}</p>
                                @endif
                            </div>
                            
                            <!-- Actions -->
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    @if($book->publication_year)
                                        {{ $book->publication_year }}
                                    @endif
                                </span>
                                <a href="{{ route('staff.book-issues.create', ['book' => $book->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium">
                                    Request Book
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No books found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($books) && $books->hasPages())
                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</x-student-layout>
