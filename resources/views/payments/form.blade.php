<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payment') }} - {{ $fee->fee_type }}
            </h2>
            <a href="{{ route('student.fees') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Fees
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Fee Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Fee Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Fee Type</p>
                            <p class="font-medium">{{ ucfirst($fee->fee_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Amount</p>
                            <p class="font-medium text-lg">${{ number_format($fee->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Due Date</p>
                            <p class="font-medium">{{ $fee->due_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Academic Year</p>
                            <p class="font-medium">{{ $fee->academic_year }}</p>
                        </div>
                    </div>
                    @if($fee->description)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Description</p>
                            <p class="text-gray-900">{{ $fee->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                    
                    <form method="POST" action="{{ route('payment.process', $fee->id) }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount to Pay *</label>
                                <input type="number" name="amount" id="amount" 
                                       value="{{ old('amount', $fee->amount) }}" 
                                       min="1" max="{{ $fee->amount }}" step="0.01"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-300 @enderror" 
                                       required>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method *</label>
                                <select name="payment_method" id="payment_method" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('payment_method') border-red-300 @enderror" 
                                        required>
                                    <option value="">Select payment method</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                    <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>Nagad</option>
                                    <option value="rocket" {{ old('payment_method') == 'rocket' ? 'selected' : '' }}>Rocket</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method Information -->
                        <div id="payment-info" class="mt-6 hidden">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">Payment Instructions</h4>
                                <div id="cash-info" class="hidden">
                                    <p class="text-sm text-blue-800">Please visit the accounts office to make cash payment.</p>
                                </div>
                                <div id="bank-info" class="hidden">
                                    <p class="text-sm text-blue-800">Transfer to: University Bank Account</p>
                                    <p class="text-sm text-blue-800">Account: 1234567890</p>
                                    <p class="text-sm text-blue-800">Reference: {{ $fee->id }}</p>
                                </div>
                                <div id="mobile-info" class="hidden">
                                    <p class="text-sm text-blue-800">You will be redirected to complete the payment.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('student.fees') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Proceed to Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            const paymentInfo = document.getElementById('payment-info');
            const cashInfo = document.getElementById('cash-info');
            const bankInfo = document.getElementById('bank-info');
            const mobileInfo = document.getElementById('mobile-info');
            
            // Hide all info sections
            cashInfo.classList.add('hidden');
            bankInfo.classList.add('hidden');
            mobileInfo.classList.add('hidden');
            
            if (this.value === 'cash') {
                paymentInfo.classList.remove('hidden');
                cashInfo.classList.remove('hidden');
            } else if (this.value === 'bank_transfer') {
                paymentInfo.classList.remove('hidden');
                bankInfo.classList.remove('hidden');
            } else if (['bkash', 'nagad', 'rocket'].includes(this.value)) {
                paymentInfo.classList.remove('hidden');
                mobileInfo.classList.remove('hidden');
            } else {
                paymentInfo.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
