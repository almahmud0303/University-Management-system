<x-staff-layout>
    <x-slot name="header">Edit Profile</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('staff.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Photo -->
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-20 w-20 rounded-full object-cover">
                            @else
                                <div class="h-20 w-20 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('profile_photo') border-red-500 @enderror">
                            @error('profile_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea id="address" name="address" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 @error('address') border-red-500 @enderror">{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Staff Specific Information -->
                    @if(Auth::user()->staff)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                                <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id', Auth::user()->staff->employee_id) }}" readonly
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                <input type="text" id="position" name="position" value="{{ old('position', Auth::user()->staff->position) }}" readonly
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                <input type="text" id="department" name="department" value="{{ Auth::user()->staff->department->name ?? 'N/A' }}" readonly
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                            </div>

                            <div>
                                <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                                <input type="text" id="hire_date" name="hire_date" value="{{ Auth::user()->staff->hire_date ? Auth::user()->staff->hire_date->format('M d, Y') : 'N/A' }}" readonly
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                            </div>
                        </div>
                    @endif

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('staff.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-staff-layout>
