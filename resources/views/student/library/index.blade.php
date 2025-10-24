<x-student-layout>
    <x-slot name="header">Library</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Library Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Books Borrowed</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $activeBookIssues->count() ?? 0 }}</dd>
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Books Returned</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $returnedBooks->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Overdue Books</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $overdueBooks->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Books</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $totalBooks ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search books by title, author, or ISBN..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <select name="category" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                <option value="Fiction" {{ request('category') === 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                <option value="Non-Fiction" {{ request('category') === 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                <option value="Textbook" {{ request('category') === 'Textbook' ? 'selected' : '' }}>Textbook</option>
                                <option value="Reference" {{ request('category') === 'Reference' ? 'selected' : '' }}>Reference</option>
                                <option value="Research" {{ request('category') === 'Research' ? 'selected' : '' }}>Research</option>
                                <option value="Journal" {{ request('category') === 'Journal' ? 'selected' : '' }}>Journal</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Available Books -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Available Books</h3>
                    @if(($availableBooks->count() ?? 0) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($availableBooks ?? [] as $book)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $book->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $book->author }}</p>
                                            <p class="text-xs text-gray-400">{{ $book->category }} • {{ $book->isbn }}</p>
                                            <div class="mt-2 flex items-center justify-between">
                                                <span class="text-xs text-green-600 font-medium">{{ $book->available_copies }} available</span>
                                                <a href="{{ route('student.library.request', $book) }}" 
                                                   class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                                                    Request Book
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No available books found.</p>
                    @endif
                </div>
            </div>

            <!-- My Book Issues -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">My Book Issues</h3>
                    @if(($myBookIssues->count() ?? 0) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($myBookIssues ?? [] as $issue)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $issue->book->title }}</div>
                                                <div class="text-sm text-gray-500">by {{ $issue->book->author }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $issue->issue_date ? $issue->issue_date->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $issue->due_date ? $issue->due_date->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($issue->status === 'issued')
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Issued
                                                    </span>
                                                @elseif($issue->status === 'returned')
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Returned
                                                    </span>
                                                @elseif($issue->status === 'overdue')
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                @elseif($issue->status === 'requested')
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Requested
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($issue->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($issue->status === 'issued')
                                                    <form method="POST" action="{{ route('student.library.return', $issue) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900 font-medium">
                                                            Return
                                                        </button>
                                                    </form>
                                                @elseif($issue->status === 'requested')
                                                    <span class="text-gray-400">Pending approval</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No book issues found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
