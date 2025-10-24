<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $hall->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.halls.edit', $hall->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Hall
                </a>
                <a href="{{ route('admin.halls.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Halls
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hall Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $hall->name }}</h1>
                            <p class="text-gray-600 mb-4">{{ $hall->code }} • {{ ucfirst($hall->type) }} Hall</p>
                            
                            @if($hall->description)
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-600">{{ $hall->description }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Capacity</p>
                                    <p class="text-lg font-semibold">{{ $hall->capacity }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Occupied</p>
                                    <p class="text-lg font-semibold">{{ $stats['total_students'] }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Available</p>
                                    <p class="text-lg font-semibold">{{ $stats['available_slots'] }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Occupancy</p>
                                    <p class="text-lg font-semibold">{{ number_format($stats['occupancy_percentage'], 1) }}%</p>
                                </div>
                            </div>

                            @if($hall->location)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Location</h3>
                                    <p class="text-gray-600">{{ $hall->location }}</p>
                                </div>
                            @endif

                            @if($hall->facilities && count($hall->facilities) > 0)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Facilities</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($hall->facilities as $facility)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $facility }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hall Statistics</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Total Students:</span>
                                        <span class="font-medium">{{ $stats['total_students'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Available Slots:</span>
                                        <span class="font-medium">{{ $stats['available_slots'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Occupancy Rate:</span>
                                        <span class="font-medium">{{ number_format($stats['occupancy_percentage'], 1) }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $hall->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $hall->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            @if($hall->students->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Assigned Students</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($hall->students as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600">
                                                            {{ substr($student->user->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $student->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $student->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->student_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $student->phone ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form method="POST" action="{{ route('admin.halls.remove-student', $student->id) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to remove this student from the hall?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Assigned</h3>
                        <p class="text-gray-500">No students are currently assigned to this hall.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
