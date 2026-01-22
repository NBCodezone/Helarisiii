<x-order-manager-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Orders Management</h2>
                    <p class="text-sm text-gray-500">Manage and track customer orders</p>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Orders List -->
    @forelse($orders as $order)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6 border-l-4 
        @if($order->status === 'pending') border-yellow-500
        @elseif($order->status === 'approved') border-green-500
        @elseif($order->status === 'shipped') border-blue-500
        @elseif($order->status === 'delivered') border-indigo-500
        @elseif($order->status === 'completed') border-gray-500
        @elseif($order->status === 'cancelled') border-red-500
        @endif">
        
        <!-- Order Header (Clickable) -->
        <div class="bg-gray-50 p-6 cursor-pointer hover:bg-gray-100 transition-colors" onclick="toggleOrder({{ $order->id }})">
            <div class="flex justify-content-between align-items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        #{{ $order->id }}
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-gray-900">Order #{{ $order->id }}</h5>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        @if($order->payment_method === 'bank_transfer')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Bank Transfer</span>
                        @else
                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-semibold">Cash on Delivery</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'approved') bg-green-100 text-green-800
                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                        @elseif($order->status === 'delivered') bg-indigo-100 text-indigo-800
                        @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform" id="icon-{{ $order->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Order Content (Collapsible) -->
        <div id="order-{{ $order->id }}" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Customer Information -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                    <h6 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Customer Information
                    </h6>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Name:</strong> <span class="text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</span></p>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Email:</strong> <span class="text-gray-900">{{ $order->email }}</span></p>
                    <p class="mb-0 text-sm"><strong class="text-gray-700">Mobile:</strong> <span class="text-gray-900">{{ $order->mobile_number }}</span></p>
                </div>

                <!-- Shipping Address -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                    <h6 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Shipping Address
                    </h6>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Region:</strong> <span class="text-gray-900">{{ $order->region->region_name }}</span></p>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Ken:</strong> <span class="text-gray-900">{{ $order->ken_name }}</span></p>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Address:</strong> <span class="text-gray-900">{{ $order->apartment }}</span></p>
                    <p class="mb-0 text-sm"><strong class="text-gray-700">Postal:</strong> <span class="text-gray-900">{{ $order->postal_code }}</span></p>
                </div>

                <!-- Order Summary -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-500">
                    <h6 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Order Summary
                    </h6>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Subtotal:</strong> <span class="text-gray-900">¥{{ number_format($order->subtotal, 0) }}</span></p>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Tax (8%):</strong> <span class="text-gray-900">¥{{ number_format($order->tax_amount, 0) }}</span></p>
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Delivery:</strong> <span class="text-gray-900">¥{{ number_format($order->delivery_charge, 0) }}</span></p>
                    @if($order->frozen_charge > 0)
                    <p class="mb-2 text-sm"><strong class="text-gray-700">Frozen Item:</strong> <span class="text-gray-900">¥{{ number_format($order->frozen_charge, 0) }}</span></p>
                    @endif
                    <hr class="my-3 border-green-300">
                    <p class="mb-0 flex justify-between items-center">
                        <strong class="text-gray-900">Total:</strong>
                        <strong class="text-green-600 text-xl" style="font-family: 'Playfair Display', serif;">¥{{ number_format($order->total_amount, 0) }}</strong>
                    </p>
                </div>
            </div>

            <!-- Delivery Schedule -->
            @if($order->delivery_date || $order->delivery_time_slot)
            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-6 mb-6 border border-orange-200">
                <h6 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Preferred Delivery Schedule
                </h6>
                <div class="flex flex-wrap gap-4">
                    @if($order->delivery_date)
                    <div class="bg-white rounded-lg px-4 py-3 border border-orange-200 shadow-sm">
                        <p class="text-xs text-gray-500 mb-1">Delivery Date</p>
                        <p class="font-bold text-orange-700">{{ $order->delivery_date->format('D, M d, Y') }}</p>
                    </div>
                    @endif
                    @if($order->delivery_time_slot)
                    <div class="bg-white rounded-lg px-4 py-3 border border-orange-200 shadow-sm">
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
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h6 class="font-bold text-gray-900 mb-4">Order Items</h6>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Product</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Quantity</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->product_name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">¥{{ number_format($item->price, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">¥{{ number_format($item->subtotal, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Receipt (if bank transfer) -->
            @if($order->payment_method === 'bank_transfer' && $order->payment_receipt)
            <div class="bg-blue-50 rounded-xl p-6 mb-6 border border-blue-200">
                <h6 class="font-bold text-gray-900 mb-4">Payment Receipt</h6>
                <div class="flex items-center space-x-4">
                    <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_receipt) }}"
                             alt="Payment Receipt"
                             class="w-32 h-32 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    </a>
                    <a href="{{ asset('storage/' . $order->payment_receipt) }}"
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center space-x-2"
                       target="_blank">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span>View Receipt</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Order Actions -->
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
                <h6 class="font-bold text-gray-900 mb-4">Order Status Management</h6>
                
                <!-- Current Status Display -->
                <div class="mb-4 p-4 rounded-lg
                    @if($order->status === 'pending') bg-yellow-50 border-2 border-yellow-400
                    @elseif($order->status === 'approved') bg-green-50 border-2 border-green-400
                    @elseif($order->status === 'shipped') bg-blue-50 border-2 border-blue-400
                    @elseif($order->status === 'delivered') bg-indigo-50 border-2 border-indigo-400
                    @elseif($order->status === 'completed') bg-gray-50 border-2 border-gray-400
                    @elseif($order->status === 'cancelled') bg-red-50 border-2 border-red-400
                    @endif">
                    <strong class="text-sm">Current Status:</strong> <span class="font-bold">{{ ucfirst($order->status) }}</span>
                </div>

                <!-- Workflow Action Buttons -->
                @if($order->status === 'pending')
                    <p class="text-gray-600 mb-4 text-sm">⚠️ This order is awaiting approval. Review payment receipt and approve to proceed.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="w-full px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-semibold flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Approve Order</span>
                            </button>
                        </form>
                        <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')" class="w-full px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-semibold flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Cancel Order</span>
                            </button>
                        </form>
                    </div>

                @elseif($order->status === 'approved')
                    <p class="text-gray-600 mb-4 text-sm">✅ Order approved! Mark as shipped when items are dispatched.</p>
                    <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="shipped">
                        <button type="submit" class="w-full px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-semibold flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                            <span>Mark as Shipped</span>
                        </button>
                    </form>

                @elseif($order->status === 'shipped')
                    <p class="text-gray-600 mb-4 text-sm">🚚 Order is on the way! Mark as delivered when customer receives it.</p>
                    <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="w-full px-6 py-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors font-semibold flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Mark as Delivered</span>
                        </button>
                    </form>

                @elseif($order->status === 'delivered')
                    <p class="text-gray-600 mb-4 text-sm">📦 Order delivered! Mark as completed once customer confirms receipt.</p>
                    <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Mark as Completed</span>
                        </button>
                    </form>

                @elseif($order->status === 'completed')
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-green-600 font-bold text-lg mb-2">✓ Order Completed</p>
                        <p class="text-gray-500 text-sm">This order has been successfully completed!</p>
                    </div>

                @elseif($order->status === 'cancelled')
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-red-600 font-bold text-lg mb-2">✗ Order Cancelled</p>
                        <p class="text-gray-500 text-sm">This order has been cancelled.</p>
                    </div>
                @endif

                <!-- Manual Status Override (Advanced) -->
                <details class="mt-6">
                    <summary class="text-gray-500 text-sm cursor-pointer hover:text-gray-700 font-medium">Advanced: Manual Status Override</summary>
                    <form action="{{ route('order-manager.orders.update-status', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div class="md:col-span-3">
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $order->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors font-semibold">
                                Update
                            </button>
                        </div>
                    </form>
                </details>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <h5 class="text-xl font-bold text-gray-900 mb-2">No orders found</h5>
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
    </script>
</x-order-manager-layout>
