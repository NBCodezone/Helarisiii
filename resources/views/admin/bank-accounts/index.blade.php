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
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Bank Accounts</h2>
                    <p class="text-sm text-gray-500">Manage your bank accounts for payments</p>
                </div>
            </div>
            <a href="{{ route('admin.bank-accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-md transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Bank Account
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="grid gap-6">
        @forelse($bankAccounts as $account)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl {{ $account->is_active ? 'ring-2 ring-green-500' : '' }}">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                        {{ $account->bank_name }}
                                    </h3>
                                    @if($account->is_active)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full mt-1">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full mt-1">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Account Holder</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $account->account_holder_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Account Number</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $account->account_number }}</p>
                                </div>
                                @if($account->branch_name)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Branch</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $account->branch_name }}</p>
                                </div>
                                @endif
                                @if($account->swift_code)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">SWIFT Code</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $account->swift_code }}</p>
                                </div>
                                @endif
                                @if($account->ifsc_code)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">IFSC Code</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $account->ifsc_code }}</p>
                                </div>
                                @endif
                            </div>

                            @if($account->additional_info)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500 mb-1">Additional Information</p>
                                    <p class="text-sm text-gray-700">{{ $account->additional_info }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col space-y-2 ml-4">
                            @if(!$account->is_active)
                                <form action="{{ route('admin.bank-accounts.activate', $account) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-semibold rounded-lg transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Activate
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-semibold rounded-lg transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form id="delete-form-{{ $account->id }}" onsubmit="return false;">
                                <button type="button" onclick="openDeleteModal(document.getElementById('delete-form-{{ $account->id }}'), 'Are you sure you want to delete this bank account?')" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold rounded-lg transition w-full">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2" style="font-family: 'Playfair Display', serif;">No Bank Accounts</h3>
                <p class="text-gray-600 mb-6">Add your first bank account to receive payments</p>
                <a href="{{ route('admin.bank-accounts.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Bank Account
                </a>
            </div>
        @endforelse
    </div>

    <script>
        function confirmDelete() {
            const form = window.pendingDeleteForm;
            if (form) {
                const formAction = '{{ route("admin.bank-accounts.destroy", ":id") }}'.replace(':id', form.id.replace('delete-form-', ''));
                const realForm = document.createElement('form');
                realForm.method = 'POST';
                realForm.action = formAction;
                realForm.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(realForm);
                realForm.submit();
            }
            closeDeleteModal();
        }
    </script>
</x-admin-layout>
