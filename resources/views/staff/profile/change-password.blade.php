<x-staff-layout>
    <x-slot name="header">Change Password</x-slot>
    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staff.profile.change-password') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password *</label>
                        <input type="password" id="current_password" name="current_password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password *</label>
                        <input type="password" id="password" name="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long.</p>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('password_confirmation') border-red-500 @enderror">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Password Requirements:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• At least 8 characters long</li>
                            <li>• Contains at least one uppercase letter</li>
                            <li>• Contains at least one lowercase letter</li>
                            <li>• Contains at least one number</li>
                            <li>• Contains at least one special character</li>
                        </ul>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('staff.profile.edit') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staff-layout>
