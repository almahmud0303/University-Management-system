<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Use Tailwind CDN instead of Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                        {{ config('app.name') }}
                    </a>
                </div>
                
                <!-- Role-based Navigation -->
                <div class="flex items-center space-x-6">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">Admin Dashboard</a>
                        <a href="{{ route('admin.departments.index') }}" class="text-gray-600 hover:text-gray-900">Departments</a>
                        <a href="{{ route('admin.teachers.index') }}" class="text-gray-600 hover:text-gray-900">Teachers</a>
                        <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-900">Students</a>
                        <a href="{{ route('admin.courses.index') }}" class="text-gray-600 hover:text-gray-900">Courses</a>
                    @elseif(Auth::user()->role === 'teacher')
                        <a href="{{ route('teacher.dashboard') }}" class="text-gray-600 hover:text-gray-900">Teacher Dashboard</a>
                        <a href="{{ route('teacher.courses.index') }}" class="text-gray-600 hover:text-gray-900">My Courses</a>
                        <a href="{{ route('teacher.exams.index') }}" class="text-gray-600 hover:text-gray-900">Assessments</a>
                    @elseif(Auth::user()->role === 'student')
                        <a href="{{ route('student.dashboard') }}" class="text-gray-600 hover:text-gray-900">Student Dashboard</a>
                    @endif
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-600 hover:text-gray-900">
                            <span class="mr-2">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @if(isset($header))
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h1 class="text-2xl font-bold">{{ $header }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        {{ $slot }}
    </main>
</body>
</html>
