<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $notice->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.notices.edit', $notice->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Notice
                </a>
                <a href="{{ route('admin.notices.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Notices
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Notice Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $notice->title }}</h1>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $notice->type === 'urgent' ? 'bg-red-100 text-red-800' : 
                                       ($notice->type === 'high' ? 'bg-orange-100 text-orange-800' : 
                                       ($notice->type === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                    {{ ucfirst($notice->type) }}
                                </span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $notice->priority === 'urgent' ? 'bg-red-100 text-red-800' : 
                                       ($notice->priority === 'high' ? 'bg-orange-100 text-orange-800' : 
                                       ($notice->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                    {{ ucfirst($notice->priority) }} Priority
                                </span>
                                @if($notice->is_pinned)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Pinned
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $notice->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $notice->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-xs text-gray-500">Published By</p>
                            <p class="text-sm font-semibold">{{ $notice->user->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-xs text-gray-500">Publish Date</p>
                            <p class="text-sm font-semibold">{{ $notice->publish_date->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-xs text-gray-500">Expiry Date</p>
                            <p class="text-sm font-semibold">{{ $notice->expiry_date ? $notice->expiry_date->format('M d, Y') : 'No expiry' }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Target Audience</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($notice->target_role) }}
                            </span>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Content</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $notice->content }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Actions</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-4">
                        @if(!$notice->is_published)
                            <form method="POST" action="{{ route('admin.notices.publish', $notice->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Publish Notice
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.notices.edit', $notice->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Edit Notice
                        </a>
                        
                        <form method="POST" action="{{ route('admin.notices.destroy', $notice->id) }}" 
                              class="inline" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Delete Notice
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
