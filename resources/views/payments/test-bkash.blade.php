<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test bKash Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">bKash Payment</h1>
                        <p class="text-gray-600">Complete your payment using bKash</p>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Payment Details</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment ID:</span>
                                <span class="font-medium">{{ $payment->transaction_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-medium text-lg">${{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fee Type:</span>
                                <span class="font-medium">{{ ucfirst($payment->fee->fee_type ?? 'Unknown') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reference:</span>
                                <span class="font-medium">{{ $payment->reference_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Test Payment Instructions -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Test Mode</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>This is a test payment page. Click the button below to simulate a successful payment.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Simulated bKash Interface -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="text-center">
                            <div class="mx-auto w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <span class="text-green-600 font-bold text-lg">bK</span>
                            </div>
                            <h3 class="text-lg font-semibold text-green-900 mb-2">bKash Payment</h3>
                            <p class="text-green-700 mb-4">Amount: ${{ number_format($payment->amount, 2) }}</p>
                            
                            <div class="space-y-3">
                                <div class="bg-white p-3 rounded border">
                                    <p class="text-sm text-gray-600">Enter bKash Mobile Number</p>
                                    <input type="text" value="01XXXXXXXXX" class="w-full text-center font-mono text-lg" readonly>
                                </div>
                                <div class="bg-white p-3 rounded border">
                                    <p class="text-sm text-gray-600">Enter bKash PIN</p>
                                    <input type="password" value="****" class="w-full text-center font-mono text-lg" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-4">
                        <form method="POST" action="{{ route('payment.simulate', $payment->transaction_id) }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md text-sm font-medium">
                                Complete Payment
                            </button>
                        </form>
                        
                        <a href="{{ route('payment.cancel') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-md text-sm font-medium">
                            Cancel Payment
                        </a>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-6 text-center text-sm text-gray-500">
                        <p>This is a test environment. No actual payment will be processed.</p>
                        <p>In production, users would be redirected to the actual bKash payment page.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
