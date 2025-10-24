<x-student-layout>
    <x-slot name="header">Make Payment</x-slot>
    <div class="py-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('student.payments.store') }}" class="space-y-6">
                    @csrf

                    <!-- Payment Information -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                        <h3 class="text-lg font-medium text-blue-900 mb-2">Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-blue-800">Description:</span>
                                <span class="text-blue-700">{{ $paymentDescription ?? 'Course Fee Payment' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-blue-800">Amount:</span>
                                <span class="text-blue-700 font-semibold">${{ number_format($amount ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    @if(isset($courseId))
                        <input type="hidden" name="course_id" value="{{ $courseId }}">
                    @endif
                    @if(isset($feeId))
                        <input type="hidden" name="fee_id" value="{{ $feeId }}">
                    @endif
                    <input type="hidden" name="amount" value="{{ $amount ?? 0 }}">
                    <input type="hidden" name="description" value="{{ $paymentDescription ?? 'Course Fee Payment' }}">

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method *</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bkash" required
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">bKash</div>
                                    <div class="text-sm text-gray-500">Pay using bKash mobile banking</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="bank_transfer" required
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Bank Transfer</div>
                                    <div class="text-sm text-gray-500">Direct bank transfer</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cash" required
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Cash Payment</div>
                                    <div class="text-sm text-gray-500">Pay at the university office</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                                  placeholder="Any additional information about this payment...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms_accepted" required
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800">Terms and Conditions</a> 
                                and confirm that the payment information provided is accurate.
                            </span>
                        </label>
                        @error('terms_accepted')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('student.fees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Instructions -->
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <h4 class="text-sm font-medium text-yellow-800 mb-2">Payment Instructions:</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• For bKash payments, you will be redirected to the bKash payment gateway</li>
                    <li>• For bank transfers, please use the reference number provided after submission</li>
                    <li>• For cash payments, visit the university finance office within 3 business days</li>
                    <li>• Keep your payment receipt for future reference</li>
                </ul>
            </div>
        </div>
    </div>
</x-student-layout>
