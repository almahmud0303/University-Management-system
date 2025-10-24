<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $staff->user->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.staff.edit', $staff->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Staff
                </a>
                <a href="{{ route('admin.staff.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Staff
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Staff Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-xl font-medium text-blue-600">
                                            {{ substr($staff->user->name, 0, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $staff->user->name }}</h1>
                                    <p class="text-gray-600">{{ $staff->designation }}</p>
                                    <p class="text-sm text-gray-500">{{ $staff->employee_id }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Department</p>
                                    <p class="text-sm font-semibold">{{ $staff->department }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Employment Type</p>
                                    <p class="text-sm font-semibold">{{ ucfirst(str_replace('-', ' ', $staff->employment_type)) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Joining Date</p>
                                    <p class="text-sm font-semibold">{{ $staff->joining_date->format('M d, Y') }}</p>
                                </div>
                            </div>

                            @if($staff->salary)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Salary</h3>
                                    <p class="text-lg font-semibold text-gray-900">${{ number_format($staff->salary, 2) }}</p>
                                </div>
                            @endif

                            @if($staff->location)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Location</h3>
                                    <p class="text-gray-600">{{ $staff->location }}</p>
                                </div>
                            @endif

                            @if($staff->bio)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Bio</h3>
                                    <p class="text-gray-600">{{ $staff->bio }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium">{{ $staff->user->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Employee ID</p>
                                        <p class="font-medium">{{ $staff->employee_id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $staff->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Issues -->
            @if($staff->bookIssues->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Book Issues</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Book
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Issue Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Return Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($staff->bookIssues as $issue)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $issue->book->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $issue->book->author }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $issue->issue_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $issue->return_date ? $issue->return_date->format('M d, Y') : 'Not returned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $issue->return_date ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $issue->return_date ? 'Returned' : 'Active' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Book Issues</h3>
                        <p class="text-gray-500">This staff member has not issued any books.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
