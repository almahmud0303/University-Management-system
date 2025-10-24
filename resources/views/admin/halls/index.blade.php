<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Halls') }}
            </h2>
            <a href="{{ route('admin.halls.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Add Hall
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($halls->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($halls as $hall)
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $hall->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $hall->location }}</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $hall->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $hall->is_available ? 'Available' : 'Occupied' }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <span>Capacity:</span>
                                            <span>{{ $hall->capacity }} students</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Assigned Students:</span>
                                            <span>{{ $hall->students()->count() }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex space-x-2">
                                        <a href="{{ route('admin.halls.show', $hall) }}" 
                                           class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded hover:bg-blue-100">
                                            View
                                        </a>
                                        <a href="{{ route('admin.halls.edit', $hall) }}" 
                                           class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1 rounded hover:bg-indigo-100">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.halls.destroy', $hall) }}" 
                                              class="inline" onsubmit="return confirm('Are you sure you want to delete this hall?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1 rounded hover:bg-red-100">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $halls->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <p class="text-gray-500">No halls found.</p>
                            <a href="{{ route('admin.halls.create') }}" 
                               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Add First Hall
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
