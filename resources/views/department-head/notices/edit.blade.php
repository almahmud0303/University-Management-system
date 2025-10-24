<x-teacher-layout>
    <x-slot name="header">Edit Notice</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Edit Notice</h3>
                            <p class="text-gray-600">Update notice: {{ $notice->title }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('department-head.notices.show', $notice) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                View Notice
                            </a>
                            <a href="{{ route('department-head.notices.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Back to Notices
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('department-head.notices.update', $notice) }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $notice->title) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content <span class="text-red-500">*</span></label>
                            <textarea name="content" id="content" rows="6" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-300 @enderror">{{ old('content', $notice->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Role -->
                        <div>
                            <label for="target_role" class="block text-sm font-medium text-gray-700">Target Role <span class="text-red-500">*</span></label>
                            <select name="target_role" id="target_role" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('target_role') border-red-300 @enderror">
                                <option value="">Select target role</option>
                                <option value="teacher" {{ old('target_role', $notice->target_role) == 'teacher' ? 'selected' : '' }}>Teachers Only</option>
                                <option value="student" {{ old('target_role', $notice->target_role) == 'student' ? 'selected' : '' }}>Students Only</option>
                                <option value="staff" {{ old('target_role', $notice->target_role) == 'staff' ? 'selected' : '' }}>Staff Only</option>
                                <option value="all" {{ old('target_role', $notice->target_role) == 'all' ? 'selected' : '' }}>All Department Members</option>
                            </select>
                            @error('target_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority" id="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="normal" {{ old('priority', $notice->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ old('priority', $notice->priority) == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority', $notice->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $notice->expiry_date ? $notice->expiry_date->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty if notice should not expire</p>
                        </div>

                        <!-- Publish Status -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $notice->is_published) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-700">
                                    Publish notice
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">If unchecked, notice will be saved as draft</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('department-head.notices.show', $notice) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Update Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-teacher-layout>
