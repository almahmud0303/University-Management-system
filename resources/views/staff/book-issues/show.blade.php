<x-staff-layout>
    <x-slot name="header">Book Issue Details</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Book Issue Information -->
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

                        <!-- Issue Details -->
                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $bookIssue->book->title }}</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Student:</span> {{ $bookIssue->student->user->name }}
                                </div>
                                <div>
                                    <span class="font-medium">Student ID:</span> {{ $bookIssue->student->student_id }}
                                </div>
                                <div>
                                    <span class="font-medium">Author:</span> {{ $bookIssue->book->author }}
                                </div>
                                <div>
                                    <span class="font-medium">ISBN:</span> {{ $bookIssue->book->isbn }}
                                </div>
                                <div>
                                    <span class="font-medium">Issue Date:</span> {{ $bookIssue->issue_date ? $bookIssue->issue_date->format('M d, Y') : 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Due Date:</span> {{ $bookIssue->due_date ? $bookIssue->due_date->format('M d, Y') : 'N/A' }}
                                </div>
                                @if($bookIssue->return_date)
                                    <div>
                                        <span class="font-medium">Return Date:</span> {{ $bookIssue->return_date->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if($bookIssue->status === 'issued')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Issued
                                </span>
                            @elseif($bookIssue->status === 'returned')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Returned
                                </span>
                            @elseif($bookIssue->status === 'overdue')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Overdue
                                </span>
                            @elseif($bookIssue->status === 'requested')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Requested
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($bookIssue->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($bookIssue->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                            <p class="text-gray-600">{{ $bookIssue->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="flex space-x-3">
                        @if($bookIssue->status === 'requested')
                            <form method="POST" action="{{ route('staff.book-issues.approve', $bookIssue->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Approve Issue
                                </button>
                            </form>
                            <form method="POST" action="{{ route('staff.book-issues.reject', $bookIssue->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                        onclick="return confirm('Are you sure you want to reject this book issue request?')">
                                    Reject Request
                                </button>
                            </form>
                        @elseif(in_array($bookIssue->status, ['issued', 'overdue']))
                            <form method="POST" action="{{ route('staff.book-issues.return', $bookIssue->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Returned
                                </button>
                            </form>
                            <form method="POST" action="{{ route('staff.book-issues.renew', $bookIssue->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Renew Issue
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('staff.book-issues.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Book Issues
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
