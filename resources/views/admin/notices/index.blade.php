<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notices') }}
            </h2>
            <a href="{{ route('admin.notices.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Add Notice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($notices->count() > 0)
                        <div class="space-y-4">
                            @foreach($notices as $notice)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $notice->title }}</h3>
                                            <p class="text-sm text-gray-600">by {{ $notice->user->name }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($notice->is_published)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-4">{{ Str::limit($notice->content, 200) }}</p>
                                    
                                    <div class="flex justify-between items-center text-sm text-gray-500">
                                        <div class="flex space-x-4">
                                            <span>Published: {{ $notice->publish_date ? $notice->publish_date->format('M d, Y') : 'Not set' }}</span>
                                            @if($notice->expiry_date)
                                                <span>Expires: {{ $notice->expiry_date->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.notices.show', $notice) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('admin.notices.edit', $notice) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this notice?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notices->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <p class="text-gray-500">No notices found.</p>
                            <a href="{{ route('admin.notices.create') }}" 
                               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Add First Notice
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
