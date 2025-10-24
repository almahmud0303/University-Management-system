<x-staff-layout>
    <x-slot name="header">Notices</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Notices</h3>
                            <p class="text-gray-600">Important announcements and updates</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search notices..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">All Priorities</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notices List -->
            <div class="space-y-6">
                @forelse($notices ?? [] as $notice)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Priority Badge -->
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $notice->priority == 'urgent' ? 'bg-red-100 text-red-800' : 
                                               ($notice->priority == 'high' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($notice->priority) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $notice->created_at->format('M d, Y') }}</span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        <a href="{{ route('staff.notices.show', $notice) }}" class="hover:text-green-600">
                                            {{ $notice->title }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Content Preview -->
                                    <p class="text-gray-600 mb-4">{{ Str::limit($notice->content, 200) }}</p>
                                    
                                    <!-- Meta Information -->
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>By: {{ $notice->createdBy->name ?? 'Unknown' }}</span>
                                        @if($notice->expiry_date)
                                            <span>Expires: {{ \Carbon\Carbon::parse($notice->expiry_date)->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- View Button -->
                                <div class="ml-4">
                                    <a href="{{ route('staff.notices.show', $notice) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7l-1.758-1.758a2 2 0 00-2.828 0L4.828 7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notices found</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no notices available at the moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($notices) && $notices->hasPages())
                <div class="mt-6">
                    {{ $notices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-staff-layout>
