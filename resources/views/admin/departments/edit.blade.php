<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Department') }}
            </h2>
            <a href="{{ route('admin.departments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Departments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.departments.update', $department) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Department Name *</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $department->name) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700">Department Code *</label>
                                <input type="text" 
                                       name="code" 
                                       id="code" 
                                       value="{{ old('code', $department->code) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('code') border-red-300 @enderror"
                                       placeholder="e.g., CS, EE, ME"
                                       required>
                                @error('code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" 
                                          id="description"
                                          rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-300 @enderror"
                                          placeholder="Department description...">{{ old('description', $department->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Head of Department -->
                            <div>
                                <label for="head_id" class="block text-sm font-medium text-gray-700">Head of Department</label>
                                <select name="head_id" 
                                        id="head_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('head_id') border-red-300 @enderror">
                                    <option value="">Select Head of Department (Optional)</option>
                                    @foreach(\App\Models\Teacher::with('user')->get() as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('head_id', $department->head_id) == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->name }} ({{ $teacher->employee_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('head_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Active Department</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.departments.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Department
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>