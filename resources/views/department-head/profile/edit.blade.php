<x-teacher-layout>
    <x-slot name="header">Edit Profile</x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Edit Profile</h3>
                            <p class="text-gray-600">Update your personal and professional information</p>
                        </div>
                        <a href="{{ route('department-head.profile.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back to Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('department-head.profile.update') }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Profile Image -->
                        <div class="text-center">
                            <div class="mx-auto h-24 w-24 rounded-full overflow-hidden bg-gray-100">
                                @if($teacher->profile_image)
                                    <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label for="profile_image" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium cursor-pointer">
                                    Change Photo
                                </label>
                                <input type="file" name="profile_image" id="profile_image" accept="image/*" class="hidden" onchange="this.form.submit()">
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $teacher->user->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $teacher->user->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth ? $teacher->date_of_birth->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-300 @enderror">
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-300 @enderror">{{ old('address', $teacher->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Employee ID -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID <span class="text-red-500">*</span></label>
                                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('employee_id') border-red-300 @enderror">
                                    @error('employee_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Position -->
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                    <input type="text" name="position" id="position" value="{{ old('position', $teacher->position) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('position') border-red-300 @enderror">
                                    @error('position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Qualification -->
                                <div>
                                    <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('qualification') border-red-300 @enderror">
                                    @error('qualification')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Joining Date -->
                                <div>
                                    <label for="joining_date" class="block text-sm font-medium text-gray-700">Joining Date</label>
                                    <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date', $teacher->joining_date ? $teacher->joining_date->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('joining_date') border-red-300 @enderror">
                                    @error('joining_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Specialization -->
                                <div class="md:col-span-2">
                                    <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                                    <textarea name="specialization" id="specialization" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('specialization') border-red-300 @enderror">{{ old('specialization', $teacher->specialization) }}</textarea>
                                    @error('specialization')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('department-head.profile.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-teacher-layout>
