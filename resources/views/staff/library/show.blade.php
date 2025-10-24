<x-staff-layout>
    <x-slot name="header">Book Details</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Book Information -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Book Icon -->
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Book Details -->
                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Author:</span> {{ $book->author }}
                                </div>
                                <div>
                                    <span class="font-medium">ISBN:</span> {{ $book->isbn }}
                                </div>
                                <div>
                                    <span class="font-medium">Publisher:</span> {{ $book->publisher ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Category:</span> {{ $book->category ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Publication Year:</span> {{ $book->publication_year ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Shelf Location:</span> {{ $book->shelf_location ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if($book->available_copies > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($book->description)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Copies</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $book->total_copies }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Available Copies</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $book->available_copies }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Issued Copies</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $book->total_copies - $book->available_copies }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.library.edit', $book) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Edit Book
                        </a>
                        <a href="{{ route('staff.book-issues.create') }}?book_id={{ $book->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Issue This Book
                        </a>
                        <a href="{{ route('staff.library.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Library
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
