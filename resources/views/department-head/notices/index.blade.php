<x-teacher-layout>
    <x-slot name="header">Department Notices</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Department Notices Management</h3>
                            <p class="text-gray-600">Create and manage notices for your department</p>
                        </div>
                        <a href="{{ route('department-head.notices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Create Notice
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search notices..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div>
                            <label for="target_role" class="block text-sm font-medium text-gray-700">Target Role</label>
                            <select name="target_role" id="target_role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Roles</option>
                                <option value="teacher" {{ request('target_role') == 'teacher' ? 'selected' : '' }}>Teachers</option>
                                <option value="student" {{ request('target_role') == 'student' ? 'selected' : '' }}>Students</option>
                                <option value="staff" {{ request('target_role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="all" {{ request('target_role') == 'all' ? 'selected' : '' }}>All</option>
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

            <!-- Notices Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($notices ?? [] as $notice)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $notice->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($notice->content, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $notice->target_role == 'all' ? 'bg-purple-100 text-purple-800' : 
                                               ($notice->target_role == 'teacher' ? 'bg-blue-100 text-blue-800' : 
                                               ($notice->target_role == 'student' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($notice->target_role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $notice->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $notice->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $notice->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('department-head.notices.show', $notice) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('department-head.notices.edit', $notice) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('department-head.notices.toggle-status', $notice) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-{{ $notice->is_published ? 'yellow' : 'green' }}-600 hover:text-{{ $notice->is_published ? 'yellow' : 'green' }}-900">
                                                    {{ $notice->is_published ? 'Unpublish' : 'Publish' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('department-head.notices.destroy', $notice) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No notices found. <a href="{{ route('department-head.notices.create') }}" class="text-blue-600 hover:text-blue-900">Create your first notice</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(isset($notices) && $notices->hasPages())
                    <div class="px-6 py-3 border-t border-gray-200">
                        {{ $notices->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-teacher-layout>
