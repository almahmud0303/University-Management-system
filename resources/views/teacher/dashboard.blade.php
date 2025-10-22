<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Welcome to Teacher Dashboard</h1>
                    <p>You are logged in as: <strong>{{ auth()->user()->name }}</strong></p>
                    <p>Role: <strong>{{ ucfirst(auth()->user()->role) }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
