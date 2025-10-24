<x-staff-layout>
    <x-slot name="header">Edit Hall</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staff.halls.update', $hall) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Hall Name and Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Hall Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $hall->name) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location *</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $hall->location) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Capacity and Facilities -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacity *</label>
                            <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $hall->capacity) }}" min="1" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('capacity') border-red-500 @enderror">
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="facilities" class="block text-sm font-medium text-gray-700">Facilities</label>
                            <input type="text" id="facilities" name="facilities" value="{{ old('facilities', is_array($hall->facilities) ? implode(', ', $hall->facilities) : $hall->facilities) }}"
                                   placeholder="e.g., AC, Projector, Whiteboard"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('facilities') border-red-500 @enderror">
                            @error('facilities')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $hall->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hall->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">Check if this hall is currently active</p>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $hall->is_available) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Available</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">Check if this hall is currently available for use</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('staff.halls.show', $hall) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Update Hall
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staff-layout>
