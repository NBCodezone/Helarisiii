<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Edit Bank Account</h2>
                    <p class="text-sm text-gray-500">Update bank account details</p>
                </div>
            </div>
            <a href="{{ route('admin.bank-accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('admin.bank-accounts.update', $bankAccount) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bank Name -->
                <div>
                    <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Bank Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $bankAccount->bank_name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('bank_name') border-red-500 @enderror">
                    @error('bank_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Holder Name -->
                <div>
                    <label for="account_holder_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Account Holder Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_holder_name" id="account_holder_name" value="{{ old('account_holder_name', $bankAccount->account_holder_name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('account_holder_name') border-red-500 @enderror">
                    @error('account_holder_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Number -->
                <div>
                    <label for="account_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Account Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_number" id="account_number" value="{{ old('account_number', $bankAccount->account_number) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('account_number') border-red-500 @enderror">
                    @error('account_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch Name -->
                <div>
                    <label for="branch_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Branch Name
                    </label>
                    <input type="text" name="branch_name" id="branch_name" value="{{ old('branch_name', $bankAccount->branch_name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('branch_name') border-red-500 @enderror">
                    @error('branch_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SWIFT Code -->
                <div>
                    <label for="swift_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        SWIFT Code
                    </label>
                    <input type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $bankAccount->swift_code) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('swift_code') border-red-500 @enderror">
                    @error('swift_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IFSC Code -->
                <div>
                    <label for="ifsc_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        IFSC Code
                    </label>
                    <input type="text" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code', $bankAccount->ifsc_code) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('ifsc_code') border-red-500 @enderror">
                    @error('ifsc_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <label for="additional_info" class="block text-sm font-semibold text-gray-700 mb-2">
                    Additional Information
                </label>
                <textarea name="additional_info" id="additional_info" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('additional_info') border-red-500 @enderror">{{ old('additional_info', $bankAccount->additional_info) }}</textarea>
                @error('additional_info')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Set as Active -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="is_active" class="ml-2 text-sm font-semibold text-gray-700">
                    Set as Active Account
                    <span class="block text-xs font-normal text-gray-500">This will deactivate all other accounts</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.bank-accounts.index') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-lg transition">
                    Update Bank Account
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
