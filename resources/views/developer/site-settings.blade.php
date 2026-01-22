<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Site Maintenance</h2>
                <p class="text-sm text-gray-500">Control when the storefront is visible to the public.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $setting->isMaintenanceMode() ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                {{ $setting->isMaintenanceMode() ? 'Maintenance Mode' : 'Live' }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        @if (session('status'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-800 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-red-800 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <form action="{{ route('developer.site-settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Site Status</h3>
                        <p class="text-sm text-gray-500 mb-4">Choose whether customers should see the storefront or the maintenance page.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($statusOptions as $value => $label)
                                <label class="border rounded-2xl p-4 cursor-pointer flex items-start space-x-3 transition {{ old('status', $setting->status) === $value ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-gray-300' }}">
                                    <input
                                        type="radio"
                                        name="status"
                                        value="{{ $value }}"
                                        class="mt-1"
                                        {{ old('status', $setting->status) === $value ? 'checked' : '' }}
                                    >
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $label }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $value === \App\Models\SiteSetting::STATUS_LIVE ? 'Everyone can browse the site normally.' : 'Show the maintenance page to visitors.' }}
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="maintenance_message" class="block text-sm font-medium text-gray-700 mb-2">Maintenance message (optional)</label>
                        <textarea
                            id="maintenance_message"
                            name="maintenance_message"
                            rows="4"
                            class="w-full rounded-2xl border-gray-200 focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Tell customers what's happening and when you'll be back.">{{ old('maintenance_message', $setting->maintenance_message) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Displayed on the maintenance page to reassure customers.</p>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-full bg-orange-600 text-white font-semibold shadow hover:bg-orange-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Current Visibility</h3>
                    <p class="text-sm text-gray-500 mb-4">What visitors experience right now.</p>
                    <dl class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <dt>Status</dt>
                            <dd class="font-semibold {{ $setting->isMaintenanceMode() ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ ucfirst($setting->status) }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Last updated</dt>
                            <dd>{{ optional($setting->updated_at)->diffForHumans() ?? 'Never' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>Maintenance since</dt>
                            <dd>{{ optional($setting->maintenance_enabled_at)->diffForHumans() ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl text-white p-6 shadow-lg">
                    <h3 class="text-lg font-semibold mb-2">Heads up</h3>
                    <p class="text-sm text-gray-200 leading-relaxed">
                        Enabling maintenance mode hides the entire storefront for everyone except logged-in developers. Use it before deploying breaking changes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
