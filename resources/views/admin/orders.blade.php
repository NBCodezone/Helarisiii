<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Orders Management</h2>
                <p class="text-sm text-gray-500">Manage and track all customer orders</p>
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
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Customer Information -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Customer Information
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-600">Name:</span> <span class="font-medium text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</span></p>
                        <p><span class="text-gray-600">Email:</span> <span class="font-medium text-gray-900">{{ $order->email }}</span></p>
                        <p><span class="text-gray-600">Mobile:</span> <span class="font-medium text-gray-900">{{ $order->mobile_number }}</span></p>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Address
                    </h4>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-gray-600">Region:</span> <span class="font-medium text-gray-900">{{ $order->region->region_name }}</span></p>
                        <p><span class="text-gray-600">Ken:</span> <span class="font-medium text-gray-900">{{ $order->ken_name }}</span></p>
                        <p><span class="text-gray-600">Address:</span> <span class="font-medium text-gray-900">{{ $order->apartment }}</span></p>
                        <p><span class="text-gray-600">Postal:</span> <span class="font-medium text-gray-900">{{ $order->postal_code }}</span></p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4">
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
                            <p class="flex justify-between"><span class="font-bold text-gray-900">Total:</span> <span class="text-xl font-bold text-purple-600">¥{{ number_format($order->total_amount, 0) }}</span></p>
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

            <!-- Payment Receipt (if bank transfer) -->
            @if($order->payment_method === 'bank_transfer' && $order->payment_receipt)
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <h4 class="font-bold text-gray-900 mb-3">Payment Receipt</h4>
                <div class="flex items-center space-x-4">
                    <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_receipt) }}"
                             alt="Payment Receipt"
                             class="w-24 h-24 object-cover rounded-lg border-2 border-blue-300 hover:border-blue-500 transition cursor-pointer">
                    </a>
                    <a href="{{ asset('storage/' . $order->payment_receipt) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition"
                       target="_blank">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Receipt
                    </a>
                </div>
            </div>
            @endif

            <!-- Order Actions -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-bold text-gray-900 mb-3">Order Status Management</h4>
                
                <!-- Current Status Display -->
                <div class="mb-4 p-4 bg-white rounded-lg border-2
                    @if($order->status === 'pending') border-yellow-500
                    @elseif($order->status === 'approved') border-green-500
                    @elseif($order->status === 'shipped') border-indigo-500
                    @elseif($order->status === 'delivered') border-blue-500
                    @elseif($order->status === 'cancelled') border-red-500
                    @endif">
                    <p class="text-sm text-gray-600 mb-1">Current Status:</p>
                    <p class="text-lg font-bold
                        @if($order->status === 'pending') text-yellow-700
                        @elseif($order->status === 'approved') text-green-700
                        @elseif($order->status === 'shipped') text-indigo-700
                        @elseif($order->status === 'delivered') text-blue-700
                        @elseif($order->status === 'cancelled') text-red-700
                        @endif">
                        {{ ucfirst($order->status) }}
                    </p>
                </div>

                <!-- Workflow Action Buttons -->
                @if($order->status === 'pending')
                    <div class="space-y-3">
                        <p class="text-sm text-gray-600 mb-3">⚠️ This order is awaiting approval. Review payment receipt and approve to proceed.</p>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Approve Order
                            </button>
                        </form>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel Order
                            </button>
                        </form>
                    </div>

                @elseif($order->status === 'approved')
                    <div class="space-y-3">
                        <p class="text-sm text-gray-600 mb-3">✅ Order approved! Mark as shipped when items are dispatched.</p>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="shipped">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                </svg>
                                Mark as Shipped
                            </button>
                        </form>
                    </div>

                @elseif($order->status === 'shipped')
                    <div class="space-y-3">
                        <p class="text-sm text-gray-600 mb-3">🚚 Order is on the way! Mark as delivered when customer receives it.</p>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Mark as Delivered
                            </button>
                        </form>
                    </div>

                @elseif($order->status === 'delivered')
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-blue-700 font-bold">✓ Order Delivered</p>
                        <p class="text-sm text-gray-600 mt-2">This order has been successfully delivered to the customer!</p>
                    </div>

                @elseif($order->status === 'cancelled')
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-red-700 font-bold">✗ Order Cancelled</p>
                        <p class="text-sm text-gray-600 mt-2">This order has been cancelled.</p>
                    </div>
                @endif

                <!-- Manual Status Override (Advanced) -->
                <details class="mt-6">
                    <summary class="cursor-pointer text-sm text-gray-600 hover:text-gray-900 font-medium">Advanced: Manual Status Override</summary>
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-3 mt-3">
                        @csrf
                        <select name="status" class="flex-1 border-gray-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $order->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update
                        </button>
                    </form>
                </details>
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
        <h3 class="text-xl font-bold text-gray-900 mb-2">No orders found</h3>
        <p class="text-gray-500">There are no orders to display at this time.</p>
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

        // Optional: Expand first order by default
        document.addEventListener('DOMContentLoaded', function() {
            const firstOrder = document.querySelector('[id^="order-"]');
            if (firstOrder) {
                const orderId = firstOrder.id.replace('order-', '');
                // toggleOrder(orderId); // Uncomment this line if you want the first order to be expanded by default
            }
        });
    </script>
</x-admin-layout>
