<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.contacts.index') }}" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-lg flex items-center justify-center transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Message Details</h2>
                    <p class="text-sm text-gray-500">Message #{{ $contact->id }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Message Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                                {{ $contact->subject }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($contact->status === 'new') bg-red-100 text-red-700
                                @elseif($contact->status === 'read') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($contact->status) }}
                            </span>
                        </div>

                        <div class="prose max-w-none">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Received on {{ $contact->created_at->format('F d, Y \a\t h:i A') }}
                            </div>
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg shadow-lg transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply via Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Sender Info -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Sender Information</h4>

                        <div class="flex items-center mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-900">{{ $contact->name }}</div>
                                <a href="mailto:{{ $contact->email }}" class="text-purple-600 hover:text-purple-800">{{ $contact->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Update Status</h4>

                        <form action="{{ route('admin.contacts.update-status', $contact->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-3">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $contact->status === 'new' ? 'border-red-300 bg-red-50' : '' }}">
                                    <input type="radio" name="status" value="new" {{ $contact->status === 'new' ? 'checked' : '' }} class="text-red-600 focus:ring-red-500">
                                    <span class="ml-3 font-medium text-gray-700">New</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $contact->status === 'read' ? 'border-yellow-300 bg-yellow-50' : '' }}">
                                    <input type="radio" name="status" value="read" {{ $contact->status === 'read' ? 'checked' : '' }} class="text-yellow-600 focus:ring-yellow-500">
                                    <span class="ml-3 font-medium text-gray-700">Read</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ $contact->status === 'replied' ? 'border-green-300 bg-green-50' : '' }}">
                                    <input type="radio" name="status" value="replied" {{ $contact->status === 'replied' ? 'checked' : '' }} class="text-green-600 focus:ring-green-500">
                                    <span class="ml-3 font-medium text-gray-700">Replied</span>
                                </label>
                            </div>
                            <button type="submit" class="w-full mt-4 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-lg transition">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 mb-4" style="font-family: 'Playfair Display', serif;">Actions</h4>

                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-admin-layout>
