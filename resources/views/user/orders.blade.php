<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">My Orders</h2>
                <p class="text-sm text-gray-500">Track and view your order history</p>
            </div>
        </div>
    </x-slot>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow" role="alert">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow" role="alert">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Orders List -->
    @forelse($orders as $order)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6 border-l-4
        @if($order->status === 'pending') border-yellow-500
        @elseif($order->status === 'approved') border-green-500
        @elseif($order->status === 'shipped') border-indigo-500
        @elseif($order->status === 'delivered') border-blue-500
        @elseif($order->status === 'cancelled') border-red-500
        @endif
        hover:shadow-xl transition-all duration-300">

        <!-- Order Header (Clickable) -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200 cursor-pointer hover:bg-gray-100 transition"
             onclick="toggleOrder({{ $order->id }})">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                        #{{ $order->id }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Order #{{ $order->id }}</h3>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    @if($order->payment_method === 'bank_transfer')
                        <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">Bank Transfer</span>
                    @else
                        <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Cash on Delivery</span>
                    @endif
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 text-sm font-bold rounded-full
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'approved') bg-green-100 text-green-700
                        @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-700
                        @elseif($order->status === 'delivered') bg-blue-100 text-blue-700
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <!-- Expand/Collapse Icon -->
                    <svg id="icon-{{ $order->id }}" class="w-6 h-6 text-gray-600 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Order Content (Collapsible) -->
        <div id="order-{{ $order->id }}" class="p-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Shipping Address -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Delivery Address
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-600">Name:</span> <span class="font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</span></p>
                        <p><span class="text-gray-600">City:</span> <span class="font-medium text-gray-900">{{ $order->region->region_name }}</span></p>
                        <p><span class="text-gray-600">Ken:</span> <span class="font-medium text-gray-900">{{ $order->ken_name }}</span></p>
                        <p><span class="text-gray-600">Address:</span> <span class="font-medium text-gray-900">{{ $order->apartment }}</span></p>
                        <p><span class="text-gray-600">Postal:</span> <span class="font-medium text-gray-900">{{ $order->postal_code }}</span></p>
                        <p><span class="text-gray-600">Mobile:</span> <span class="font-medium text-gray-900">{{ $order->mobile_number }}</span></p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Order Summary
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-600">Subtotal:</span> <span class="font-medium text-gray-900">¥{{ number_format($order->subtotal, 0) }}</span></p>
                        <p><span class="text-gray-600">Tax (8%):</span> <span class="font-medium text-gray-900">¥{{ number_format($order->tax_amount, 0) }}</span></p>
                        <p><span class="text-gray-600">Delivery:</span> <span class="font-medium text-gray-900">¥{{ number_format($order->delivery_charge, 0) }}</span></p>
                        @if($order->frozen_charge > 0)
                        <p><span class="text-gray-600">Frozen Item:</span> <span class="font-medium text-gray-900">¥{{ number_format($order->frozen_charge, 0) }}</span></p>
                        @endif
                        <div class="pt-2 border-t border-gray-300">
                            <p class="flex justify-between"><span class="font-bold text-gray-900">Total:</span> <span class="text-xl font-bold text-blue-600">¥{{ number_format($order->total_amount, 0) }}</span></p>
                        </div>
                        @if($order->coins_earned > 0)
                        <div class="pt-2 border-t border-amber-300 mt-3 bg-gradient-to-r from-amber-50 to-yellow-50 -mx-4 px-4 py-3 rounded-lg">
                            <p class="flex items-center justify-between">
                                <span class="flex items-center text-amber-700 font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                    </svg>
                                    Coins Earned:
                                </span> 
                                <span class="text-xl font-bold text-amber-600">{{ number_format($order->coins_earned, 2) }}</span>
                            </p>
                            <p class="text-xs text-amber-600 mt-1">🎉 You earned 5% rewards on this order!</p>
                        </div>
                        @endif
                        <div class="pt-2 border-t border-gray-300 mt-3">
                            <p class="text-xs text-gray-600">Payment Method:</p>
                            <p class="font-medium text-gray-900">
                                @if($order->payment_method === 'bank_transfer')
                                    Bank Transfer
                                @else
                                    Cash on Delivery
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Schedule -->
            @if($order->delivery_date || $order->delivery_time_slot)
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-4 mb-6 border border-orange-200">
                <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Preferred Delivery Schedule
                </h4>
                <div class="flex flex-wrap gap-4">
                    @if($order->delivery_date)
                    <div class="bg-white rounded-lg px-4 py-2 border border-orange-200 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Delivery Date</p>
                        <p class="font-bold text-orange-700">{{ $order->delivery_date->format('D, M d, Y') }}</p>
                    </div>
                    @endif
                    @if($order->delivery_time_slot)
                    <div class="bg-white rounded-lg px-4 py-2 border border-orange-200 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Time Slot</p>
                        @php
                            $timeSlots = [
                                '8-12' => '8:00 AM - 12:00 PM',
                                '12-14' => '12:00 PM - 2:00 PM',
                                '14-16' => '2:00 PM - 4:00 PM',
                                '16-18' => '4:00 PM - 6:00 PM',
                                '18-20' => '6:00 PM - 8:00 PM',
                                '19-21' => '7:00 PM - 9:00 PM',
                            ];
                        @endphp
                        <p class="font-bold text-orange-700">{{ $timeSlots[$order->delivery_time_slot] ?? $order->delivery_time_slot }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Order Items -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-gray-900 mb-3">Order Items</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Product</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Price</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Quantity</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->product_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">¥{{ number_format($item->price, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">¥{{ number_format($item->subtotal, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modern Order Tracking Timeline -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-6">
                <h4 class="font-bold text-gray-900 mb-6 flex items-center text-lg">
                    <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Order Tracking
                </h4>

                <!-- Timeline -->
                <div class="relative">
                    @php
                        $statuses = ['pending', 'approved', 'shipped', 'delivered'];
                        $statusLabels = [
                            'pending' => 'Order Placed',
                            'approved' => 'Approved',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered'
                        ];
                        $statusIcons = [
                            'pending' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                            'approved' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'shipped' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0',
                            'delivered' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
                        ];
                        
                        $currentIndex = array_search($order->status, $statuses);
                        if ($currentIndex === false) {
                            $currentIndex = 0; // Default to pending if status not found
                        }
                        
                        // If order is cancelled, show different view
                        $isCancelled = $order->status === 'cancelled';
                    @endphp

                    @if($isCancelled)
                        <!-- Cancelled Order Display -->
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center animate-pulse">
                                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-red-700 mb-2">Order Cancelled</p>
                            <p class="text-gray-600">This order has been cancelled. If you have any questions, please contact support.</p>
                        </div>
                    @else
                        <!-- Progress Timeline -->
 <div class="flex items-center justify-between mb-2">
                            @foreach($statuses as $index => $status)
                                <div class="flex flex-col items-center flex-1 relative">
                                    <!-- Status Circle -->
                                    <div class="relative z-10 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full border-4 transition-all duration-300
                                        @if($index <= $currentIndex)
                                            {{ $index == $currentIndex ? 'bg-blue-600 border-blue-600 ring-4 ring-blue-200 animate-pulse' : 'bg-green-600 border-green-600' }}
                                        @else
                                            bg-gray-200 border-gray-300
                                        @endif">
                                        <svg class="w-6 h-6 md:w-7 md:h-7
                                            @if($index <= $currentIndex) text-white
                                            @else text-gray-400
                                            @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($index < $currentIndex)
                                                <!-- Completed: Show checkmark -->
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            @else
                                                <!-- Current or Pending: Show status icon -->
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcons[$status] }}"/>
                                            @endif
                                        </svg>
                                    </div>

                                    <!-- Connecting Line (not for last item) -->
                                    @if($index < count($statuses) - 1)
                                        <div class="absolute top-6 md:top-7 left-1/2 w-full h-1 -z-0 hidden sm:block">
                                            <div class="h-full
                                                @if($index < $currentIndex) bg-green-600
                                                @else bg-gray-300
                                                @endif transition-all duration-300">
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Status Label -->
                                    <div class="mt-3 text-center">
                                        <p class="text-xs md:text-sm font-semibold
                                            @if($index <= $currentIndex) text-gray-900
                                            @else text-gray-500
                                            @endif">
                                            {{ $statusLabels[$status] }}
                                        </p>
                                        @if($index == $currentIndex)
                                            <p class="text-xs text-blue-600 mt-1 font-bold">● Current</p>
                                        @elseif($index < $currentIndex)
                                            <p class="text-xs text-green-600 mt-1">✓ Done</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Status Description -->
                        <div class="mt-8 p-4 bg-white rounded-lg border-l-4
                            @if($order->status === 'pending') border-yellow-500 bg-yellow-50
                            @elseif($order->status === 'approved') border-green-500 bg-green-50
                            @elseif($order->status === 'shipped') border-indigo-500 bg-indigo-50
                            @elseif($order->status === 'delivered') border-blue-500 bg-blue-50
                            @endif">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if($order->status === 'pending')
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($order->status === 'approved')
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($order->status === 'shipped')
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0 a2 2 0 114 0"/>
                                        </svg>
                                    @elseif($order->status === 'delivered')
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-bold
                                        @if($order->status === 'pending') text-yellow-800
                                        @elseif($order->status === 'approved') text-green-800
                                        @elseif($order->status === 'shipped') text-indigo-800
                                        @elseif($order->status === 'delivered') text-blue-800
                                        @endif">
                                        @if($order->status === 'pending')
                                            Order Placed - Awaiting Approval
                                        @elseif($order->status === 'approved')
                                            Order Approved - Being Prepared
                                        @elseif($order->status === 'shipped')
                                            Order Shipped - On The Way
                                        @elseif($order->status === 'delivered')
                                            Order Delivered - Thank You!
                                        @endif
                                    </p>
                                    <p class="mt-1 text-sm
                                        @if($order->status === 'pending') text-yellow-700
                                        @elseif($order->status === 'approved') text-green-700
                                        @elseif($order->status === 'shipped') text-indigo-700
                                        @elseif($order->status === 'delivered') text-blue-700
                                        @endif">
                                        @if($order->status === 'pending')
                                            @if($order->payment_method === 'bank_transfer')
                                                We are verifying your payment. Once approved, your order will be processed.
                                            @else
                                                Your order has been placed and is awaiting approval. We'll notify you once it's approved.
                                            @endif
                                        @elseif($order->status === 'approved')
                                            Great news! Your order has been approved and is being prepared for shipment.
                                        @elseif($order->status === 'shipped')
                                            Your order is on its way to you! You'll receive it soon.
                                        @elseif($order->status === 'delivered')
                                            Your order has been delivered to your address. We hope you enjoy your purchase!
                                        @endif
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500">
                                        <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-end">
                <a href="{{ route('order.invoice.download', $order->id) }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Invoice
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No orders yet</h3>
        <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Start Shopping
        </a>
    </div>
    @endforelse

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @endif

    <script>
        function toggleOrder(orderId) {
            const content = document.getElementById('order-' + orderId);
            const icon = document.getElementById('icon-' + orderId);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-admin-layout>
