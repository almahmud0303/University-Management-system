<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left: Enhanced Icon and Header -->
                <div class="lg:w-1/2 w-full text-center lg:text-left">
                    <div class="mx-auto lg:mx-0 h-24 lg:h-32 w-24 lg:w-32 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-2xl transform hover:scale-105 transition-all duration-300 mb-8">
                        <svg class="h-12 lg:h-16 w-12 lg:w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl lg:text-5xl font-extrabold text-gray-900 mb-4">
                        University Management System
                    </h1>
                    <h2 class="text-xl lg:text-2xl font-semibold text-indigo-600 mb-4">
                        Welcome Back!
                    </h2>
                    <p class="text-base lg:text-lg text-gray-600 leading-relaxed">
                        Sign in to your account to access the comprehensive university management platform. 
                        Manage students, courses, faculty, and more with ease.
                    </p>
                    
                    <!-- Features List -->
                    <div class="mt-8 space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Student & Faculty Management
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Course & Exam Scheduling
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Real-time Analytics & Reports
                        </div>
                    </div>
                </div>

                <!-- Right: Enhanced Login Form Card -->
                <div class="lg:w-1/2 w-full">
                    <div class="bg-white py-10 px-8 shadow-2xl rounded-3xl border border-gray-100 w-full max-w-md mx-auto">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Sign In</h3>
                            <p class="text-gray-600">Enter your credentials to continue</p>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-6" :status="session('status')" />
                        
                        <!-- Logout Success Message -->
                        @if (session('logout'))
                            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ __('You have been successfully logged out.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <x-text-input id="email" 
                                        class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autofocus 
                                        autocomplete="username" 
                                        placeholder="Enter your email" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700 mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input id="password" 
                                        class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="current-password" 
                                        placeholder="Enter your password" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember_me" 
                                        type="checkbox" 
                                        class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors duration-200" 
                                        name="remember">
                                    <label for="remember_me" class="ml-3 block text-sm font-medium text-gray-700">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" 
                                           class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                                            {{ __('Forgot password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div>
                                <button type="submit" 
                                        class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                                        <svg class="h-6 w-6 text-indigo-300 group-hover:text-indigo-200 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    {{ __('Sign In') }}
                                </button>
                            </div>

                            <!-- Demo Credentials -->
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-semibold text-blue-800 mb-2">Demo Credentials:</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    <p><strong>Admin:</strong> admin@ums.com / password</p>
                                    <p><strong>Teacher:</strong> teacher@ums.com / password</p>
                                    <p><strong>Student:</strong> student@ums.com / password</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>