<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Teacher') }}
            </h2>
            <a href="{{ route('admin.teachers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Teachers
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Full Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Phone Number')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                    <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="gender" :value="__('Gender')" />
                                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="address" :value="__('Address')" />
                                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Professional Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Professional Information</h3>
                                
                                <div>
                                    <x-input-label for="employee_id" :value="__('Employee ID')" />
                                    <x-text-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" required />
                                    <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="department_id" :value="__('Department')" />
                                    <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="designation" :value="__('Designation')" />
                                    <x-text-input id="designation" class="block mt-1 w-full" type="text" name="designation" :value="old('designation')" required />
                                    <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="qualification" :value="__('Qualification')" />
                                    <x-text-input id="qualification" class="block mt-1 w-full" type="text" name="qualification" :value="old('qualification')" />
                                    <x-input-error :messages="$errors->get('qualification')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="specialization" :value="__('Specialization')" />
                                    <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization" :value="old('specialization')" />
                                    <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="joining_date" :value="__('Joining Date')" />
                                    <x-text-input id="joining_date" class="block mt-1 w-full" type="date" name="joining_date" :value="old('joining_date')" required />
                                    <x-input-error :messages="$errors->get('joining_date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="salary" :value="__('Salary')" />
                                    <x-text-input id="salary" class="block mt-1 w-full" type="number" name="salary" :value="old('salary')" step="0.01" min="0" />
                                    <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.teachers.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Teacher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
