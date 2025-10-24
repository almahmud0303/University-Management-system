<x-teacher-layout>
    <x-slot name="header">Change Password</x-slot>
    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                            <p class="text-gray-600">Update your account password</p>
                        </div>
                        <a href="{{ route('department-head.profile.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back to Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('department-head.profile.change-password') }}" class="p-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" id="current_password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-300 @enderror">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long.</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password_confirmation') border-red-300 @enderror">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-md">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Password Requirements:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• At least 8 characters long</li>
                            <li>• Contains uppercase and lowercase letters</li>
                            <li>• Contains at least one number</li>
                            <li>• Contains at least one special character</li>
                        </ul>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('department-head.profile.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-teacher-layout>
