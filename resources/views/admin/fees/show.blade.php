<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fee Record - {{ $fee->fee_type }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.fees.edit', $fee->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Fee
                </a>
                <a href="{{ route('admin.fees.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Fees
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Fee Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ ucfirst($fee->fee_type) }} Fee</h1>
                            <p class="text-gray-600 mb-4">Fee ID: #{{ $fee->id }}</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Total Amount</p>
                                    <p class="text-lg font-semibold">${{ number_format($fee->amount, 2) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Paid Amount</p>
                                    <p class="text-lg font-semibold">${{ number_format($fee->paid_amount, 2) }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Due Date</p>
                                    <p class="text-lg font-semibold">{{ $fee->due_date->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p class="text-lg font-semibold {{ $fee->status === 'paid' ? 'text-green-600' : ($fee->status === 'overdue' ? 'text-red-600' : 'text-yellow-600') }}">
                                        {{ ucfirst($fee->status) }}
                                    </p>
                                </div>
                            </div>

                            @if($fee->notes)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Notes</h3>
                                    <p class="text-gray-600">{{ $fee->notes }}</p>
                                </div>
                            @endif

                            @if($fee->paid_date)
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">Payment Information</h3>
                                    <p class="text-gray-600">Paid on: {{ $fee->paid_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h3>
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600">
                                                {{ substr($fee->student->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $fee->student->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $fee->student->student_id }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium">{{ $fee->student->user->email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-medium">{{ $fee->student->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Actions -->
                            @if($fee->status !== 'paid')
                                <div class="mt-4">
                                    <form method="POST" action="{{ route('admin.fees.mark-paid', $fee->id) }}" 
                                          onsubmit="return confirm('Are you sure you want to mark this fee as paid?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Mark as Paid
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            @if($fee->paid_amount > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Payment History</h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Payment Received</h4>
                                    <p class="text-sm text-gray-600">{{ $fee->paid_date ? $fee->paid_date->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-green-600">${{ number_format($fee->paid_amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">of ${{ number_format($fee->amount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
