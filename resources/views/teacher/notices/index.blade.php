<x-teacher-layout>
    <x-slot name="header">Notices</x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            
            <div class="mb-4 flex justify-between">
                <h2 class="text-2xl font-bold text-gray-900">University Notices</h2>
                <div class="flex space-x-2">
                    <input type="text" placeholder="Search notices..." class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <select class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        <option value="academic">Academic</option>
                        <option value="administrative">Administrative</option>
                        <option value="event">Event</option>
                        <option value="emergency">Emergency</option>
                    </select>
                </div>
            </div>

            <!-- Notice Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12 7l-1.758-1.758a2 2 0 00-2.828 0L4.828 7z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Notices</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $notices->total() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Published</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $notices->where('is_published', true)->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Recent (7 days)</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $recentNotices ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">High Priority</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $notices->where('priority', 'high')->count() ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notices List -->
            <div class="space-y-6">
                @forelse($notices ?? [] as $notice)
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $notice->title }}</h3>
                                        @if($notice->priority === 'high')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                High Priority
                                            </span>
                                        @elseif($notice->priority === 'medium')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Medium Priority
                                            </span>
                                        @endif
                                        
                                        @if($notice->is_published)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3">{{ Str::limit($notice->content, 200) }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>By: {{ $notice->user->name ?? 'Admin' }}</span>
                                        <span>•</span>
                                        <span>{{ $notice->created_at->format('M d, Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $notice->target_audience ?? 'All' }}</span>
                                        @if($notice->views)
                                            <span>•</span>
                                            <span>{{ $notice->views }} views</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-shrink-0 ml-4">
                                    <a href="{{ route('teacher.notices.show', $notice) }}" 
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
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
            <div class="mt-6">
                {{ $notices->links() ?? '' }}
            </div>
        </div>
    </div>
</x-teacher-layout>
