<x-staff-layout>
    <x-slot name="header">Hall Details</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Hall Information -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <!-- Hall Icon -->
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Hall Details -->
                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-900 mb-2">{{ $hall->name }}</h1>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Location:</span> {{ $hall->location ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Capacity:</span> {{ $hall->capacity }} people
                                </div>
                                <div>
                                    <span class="font-medium">Facilities:</span> {{ is_array($hall->facilities) ? implode(', ', $hall->facilities) : ($hall->facilities ?? 'N/A') }}
                                </div>
                                <div>
                                    <span class="font-medium">Created:</span> {{ $hall->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex-shrink-0">
                            @if(!$hall->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @elseif($hall->is_available)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Occupied
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($hall->description)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $hall->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Capacity</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $hall->capacity }} people</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Status</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        @if(!$hall->is_active)
                                            Inactive
                                        @elseif($hall->is_available)
                                            Available
                                        @else
                                            Occupied
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('staff.halls.edit', $hall) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit Hall
                        </a>
                        @if($hall->is_active)
                            <form method="POST" action="{{ route('staff.halls.toggle-availability', $hall) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    {{ $hall->is_available ? 'Mark Occupied' : 'Mark Available' }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('staff.halls.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Halls
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>
