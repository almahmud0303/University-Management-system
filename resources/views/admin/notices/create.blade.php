<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Notice') }}
            </h2>
            <a href="{{ route('admin.notices.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Notices
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.notices.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Notice title">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="md:col-span-2">
                                <label for="content" class="block text-sm font-medium text-gray-700">Content *</label>
                                <textarea id="content" name="content" rows="6" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Notice content...">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                                <select id="type" name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select type</option>
                                    <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                                    <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Exam</option>
                                    <option value="fee" {{ old('type') == 'fee' ? 'selected' : '' }}>Fee</option>
                                    <option value="library" {{ old('type') == 'library' ? 'selected' : '' }}>Library</option>
                                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                <select id="priority" name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Target Role -->
                            <div>
                                <label for="target_role" class="block text-sm font-medium text-gray-700">Target Audience</label>
                                <select id="target_role" name="target_role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="all" {{ old('target_role', 'all') == 'all' ? 'selected' : '' }}>All Users</option>
                                    <option value="student" {{ old('target_role') == 'student' ? 'selected' : '' }}>Students Only</option>
                                    <option value="teacher" {{ old('target_role') == 'teacher' ? 'selected' : '' }}>Teachers Only</option>
                                    <option value="staff" {{ old('target_role') == 'staff' ? 'selected' : '' }}>Staff Only</option>
                                    <option value="admin" {{ old('target_role') == 'admin' ? 'selected' : '' }}>Admins Only</option>
                                </select>
                                @error('target_role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                                <select id="department_id" name="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Departments</option>
                                    @foreach(\App\Models\Department::where('is_active', true)->get() as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Publish Date -->
                            <div>
                                <label for="publish_date" class="block text-sm font-medium text-gray-700">Publish Date</label>
                                <input type="datetime-local" id="publish_date" name="publish_date" value="{{ old('publish_date', now()->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('publish_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <input type="datetime-local" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('expiry_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Options -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Status Options</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="is_published" class="ml-2 text-sm text-gray-700">
                                        Publish immediately
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="is_pinned" class="ml-2 text-sm text-gray-700">
                                        Pin to top (show at the top of notice list)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.notices.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
