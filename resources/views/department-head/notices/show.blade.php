<x-teacher-layout>
    <x-slot name="header">Notice Details</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $notice->title }}</h3>
                            <p class="text-gray-600">Notice Details</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('department-head.notices.edit', $notice) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Edit Notice
                            </a>
                            <a href="{{ route('department-head.notices.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Back to Notices
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Status and Priority -->
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $notice->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $notice->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $notice->priority == 'urgent' ? 'bg-red-100 text-red-800' : 
                               ($notice->priority == 'high' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($notice->priority) }} Priority
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $notice->target_role == 'all' ? 'bg-purple-100 text-purple-800' : 
                               ($notice->target_role == 'teacher' ? 'bg-blue-100 text-blue-800' : 
                               ($notice->target_role == 'student' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                            For {{ ucfirst($notice->target_role) }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="prose max-w-none">
                        <div class="text-gray-900 whitespace-pre-wrap">{{ $notice->content }}</div>
                    </div>

                    <!-- Meta Information -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $notice->created_at->format('F d, Y \a\t g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $notice->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($notice->expiry_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expires</dt>
                                    <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($notice->expiry_date)->format('F d, Y') }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                <dd class="text-sm text-gray-900">{{ $notice->createdBy->name ?? 'Unknown' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Actions</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('department-head.notices.edit', $notice) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit Notice
                        </a>
                        
                        <form method="POST" action="{{ route('department-head.notices.toggle-status', $notice) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-{{ $notice->is_published ? 'yellow' : 'green' }}-600 hover:bg-{{ $notice->is_published ? 'yellow' : 'green' }}-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                {{ $notice->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('department-head.notices.destroy', $notice) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this notice? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Delete Notice
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-teacher-layout>
