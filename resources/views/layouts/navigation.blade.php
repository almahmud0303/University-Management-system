<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                        UMS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth

                    <!-- Debug Info -->
                        <div class="text-xs text-gray-500">
                            User: {{ Auth::user()->name }} | Role: {{ Auth::user()->role }}
                        </div>
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')">
                                {{ __('Departments') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers.*')">
                                {{ __('Teachers') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
                                {{ __('Students') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                                {{ __('Staff') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')">
                                {{ __('Courses') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.exams.index')" :active="request()->routeIs('admin.exams.*')">
                                {{ __('Exams') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')">
                                {{ __('Fees') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.notices.index')" :active="request()->routeIs('admin.notices.*')">
                                {{ __('Notices') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.halls.index')" :active="request()->routeIs('admin.halls.*')">
                                {{ __('Halls') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isTeacher())
                            <x-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.*')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isStudent())
                            <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.*')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isStaff())
                            <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.*')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                            <x-nav-link :href="route('staff.library.index')" :active="request()->routeIs('staff.library.*')">
                                {{ __('Library') }}
                            </x-nav-link>
                            <x-nav-link :href="route('staff.halls.index')" :active="request()->routeIs('staff.halls.*')">
                                {{ __('Halls') }}
                            </x-nav-link>
                        @elseif(auth()->user()->isDepartmentHead())
                            <x-nav-link :href="route('department-head.dashboard')" :active="request()->routeIs('department-head.*')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Simple Logout Button for Testing -->
                <form method="POST" action="{{ route('logout') }}" class="mr-4">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Logout
                    </button>
                </form>
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" class="hidden" id="logout-form">
                            @csrf
                        </form>
                        
                        <x-dropdown-link href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')">
                        {{ __('Departments') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers.*')">
                        {{ __('Teachers') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
                        {{ __('Students') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                        {{ __('Staff') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')">
                        {{ __('Courses') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.exams.index')" :active="request()->routeIs('admin.exams.*')">
                        {{ __('Exams') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')">
                        {{ __('Fees') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.notices.index')" :active="request()->routeIs('admin.notices.*')">
                        {{ __('Notices') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.halls.index')" :active="request()->routeIs('admin.halls.*')">
                        {{ __('Halls') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isTeacher())
                    <x-responsive-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.*')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isStudent())
                    <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.*')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @elseif(auth()->user()->isStaff())
                    <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.*')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
                @elseif(auth()->user()->isDepartmentHead())
                    <x-responsive-nav-link :href="route('department-head.dashboard')" :active="request()->routeIs('department-head.*')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Simple Logout Button for Mobile -->
                <form method="POST" action="{{ route('logout') }}" class="px-4">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>