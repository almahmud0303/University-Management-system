<x-staff-layout>
    <x-slot name="header">Student Details</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Student Information -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Student Avatar -->
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-green-100 flex items-center justify-center">
                                @if($student->user->profile_photo_path)
                                    <img src="{{ Storage::url($student->user->profile_photo_path) }}" alt="{{ $student->user->name }}" class="h-16 w-16 rounded-full object-cover">
                                @else
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $student->user->name }}</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Student ID:</span> {{ $student->student_id }}
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span> {{ $student->user->email }}
                                </div>
                                <div>
                                    <span class="font-medium">Phone:</span> {{ $student->user->phone ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Department:</span> {{ $student->department->name ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Academic Year:</span> {{ $student->academic_year ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Semester:</span> {{ $student->semester ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Date of Birth:</span> {{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Gender:</span> {{ ucfirst($student->gender ?? 'N/A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if($student->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @elseif($student->status === 'inactive')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @elseif($student->status === 'graduated')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Graduated
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($student->status ?? 'Unknown') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($student->address)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Address</h3>
                            <p class="text-gray-600">{{ $student->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Enrolled Courses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->enrollments->count() }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Credits</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->completed_credits ?? 0 }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Books Issued</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->bookIssues->where('status', 'issued')->count() }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Overdue Books</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $student->bookIssues->where('status', 'overdue')->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Book Issues -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Book Issues</h3>
                    @if($student->bookIssues && $student->bookIssues->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($student->bookIssues->take(5) as $issue)
                                        <tr>
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
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Issued
                                                    </span>
                                                @elseif($issue->status === 'returned')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Returned
                                                    </span>
                                                @elseif($issue->status === 'overdue')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($issue->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No book issues found for this student.</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.book-issues.create') }}?student_id={{ $student->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Issue Book
                        </a>
                        <a href="{{ route('staff.students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Students
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
