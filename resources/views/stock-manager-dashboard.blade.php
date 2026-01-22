<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">Stock Manager Dashboard</h2>
                    <p class="text-sm text-gray-500">Real-time inventory monitoring & notifications</p>
                </div>
            </div>
            <button onclick="refreshData()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                <i class="fas fa-sync-alt mr-2"></i>Refresh
            </button>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Products -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Products</p>
                    <h3 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;" id="totalProducts">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Low Stock Alerts</p>
                    <h3 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;" id="lowStockCount">{{ $stats['low_stock_count'] }}</h3>
                    <p class="text-xs text-yellow-600 mt-1">≤ 10 items</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Out of Stock</p>
                    <h3 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;" id="outOfStockCount">{{ $stats['out_of_stock_count'] }}</h3>
                    <p class="text-xs text-red-600 mt-1">0 items</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Unread Notifications -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Unread Alerts</p>
                    <h3 class="text-3xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;" id="unreadNotificationsCount">{{ $stats['unread_notifications_count'] }}</h3>
                    <p class="text-xs text-blue-600 mt-1">New notifications</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Notifications Section -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                    <i class="fas fa-bell text-yellow-500 mr-2"></i>Stock Notifications
                </h3>
                @if($unreadNotifications->count() > 0)
                    <form action="{{ route('stock-manager.notifications.read-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            <i class="fas fa-check-double mr-1"></i>Mark All as Read
                        </button>
                    </form>
                @endif
            </div>
            <div class="p-6" id="notificationsList">
                @forelse($unreadNotifications as $notification)
                    <div class="bg-{{ $notification->type === 'out_of_stock' ? 'red' : 'yellow' }}-50 border-l-4 border-{{ $notification->type === 'out_of_stock' ? 'red' : 'yellow' }}-500 p-4 mb-3 rounded-lg" id="notification-{{ $notification->id }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-grow">
                                <h4 class="font-semibold text-gray-900 flex items-center">
                                    @if($notification->type === 'out_of_stock')
                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                    @else
                                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                                    @endif
                                    {{ $notification->message }}
                                </h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="markAsRead({{ $notification->id }})" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="deleteNotification({{ $notification->id }})" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>No unread notifications
                    </p>
                @endforelse

                @if($recentNotifications->where('is_read', true)->count() > 0)
                    <hr class="my-4">
                    <h4 class="text-sm font-semibold text-gray-500 mb-3">Recent (Read)</h4>
                    @foreach($recentNotifications->where('is_read', true)->take(5) as $notification)
                        <div class="bg-gray-50 border-l-4 border-gray-300 p-3 mb-2 rounded opacity-60" id="notification-{{ $notification->id }}">
                            <div class="flex justify-between items-start">
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-700">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <button onclick="deleteNotification({{ $notification->id }})" class="px-2 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 transition text-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>Quick Actions
            </h3>
            <a href="{{ route('stock-manager.stocks.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
                <i class="fas fa-list mr-2"></i>View All Products
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Stock Products -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>Low Stock Products
                    </h3>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                        {{ $lowStockProducts->count() }} items
                    </span>
                </div>
                <div class="p-6">
                    @if($lowStockProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockProducts->take(10) as $product)
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 hover:shadow-md transition-all duration-300 border-l-4 border-yellow-500" id="low-stock-{{ $product->id }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($product->product_name, 25) }}</h4>
                                        <p class="text-xs text-gray-600">{{ $product->category_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-200 text-yellow-800" id="stock-display-{{ $product->id }}">
                                        {{ $product->stock }}
                                    </span>
                                    <input type="number" id="stock-input-{{ $product->id }}" value="{{ $product->stock }}" min="0"
                                        class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm">
                                    <button onclick="updateStock({{ $product->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs font-semibold">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($lowStockProducts->count() > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('stock-manager.stocks.index', ['filter' => 'low']) }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-semibold">
                                View all {{ $lowStockProducts->count() }} low stock items →
                            </a>
                        </div>
                    @endif
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                        <p class="font-semibold">No low stock products</p>
                        <p class="text-sm">All products have sufficient stock</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Out of Stock Products -->
        <div>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800" style="font-family: 'Playfair Display', serif;">
                        <i class="fas fa-times-circle text-red-500 mr-2"></i>Out of Stock Products
                    </h3>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                        {{ $outOfStockProducts->count() }} items
                    </span>
                </div>
                <div class="p-6">
                    @if($outOfStockProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($outOfStockProducts->take(10) as $product)
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 hover:shadow-md transition-all duration-300 border-l-4 border-red-500" id="out-stock-{{ $product->id }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ Str::limit($product->product_name, 25) }}</h4>
                                        <p class="text-xs text-gray-600">{{ $product->category_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-200 text-red-800">
                                        0
                                    </span>
                                    <input type="number" id="stock-input-out-{{ $product->id }}" value="0" min="0"
                                        class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm" placeholder="Qty">
                                    <button onclick="updateStockOut({{ $product->id }})"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs font-semibold">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($outOfStockProducts->count() > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('stock-manager.stocks.index', ['filter' => 'out']) }}" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                                View all {{ $outOfStockProducts->count() }} out of stock items →
                            </a>
                        </div>
                    @endif
                    @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                        <p class="font-semibold">No out of stock products</p>
                        <p class="text-sm">All products are available</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform translate-y-full opacity-0 transition-all duration-300 z-50">
        <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span id="toast-message">Stock updated successfully!</span>
        </div>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- JavaScript for real-time updates -->
    <script>
        // Setup CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Mark notification as read
        function markAsRead(id) {
            fetch(`/stock-manager/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const notification = document.getElementById(`notification-${id}`);
                if (notification) {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
                refreshData();
            });
        }

        // Delete notification
        function deleteNotification(id) {
            if (confirm('Are you sure you want to delete this notification?')) {
                fetch(`/stock-manager/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const notification = document.getElementById(`notification-${id}`);
                    if (notification) {
                        notification.style.opacity = '0';
                        setTimeout(() => notification.remove(), 300);
                    }
                    refreshData();
                });
            }
        }

        // Refresh stock data
        function refreshData() {
            fetch('/stock-manager/stock-data')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('lowStockCount').textContent = data.low_stock_count;
                    document.getElementById('outOfStockCount').textContent = data.out_of_stock_count;
                    document.getElementById('unreadNotificationsCount').textContent = data.unread_notifications_count;
                });
        }

        // Update stock for low stock products
        function updateStock(productId) {
            const input = document.getElementById(`stock-input-${productId}`);
            const newStock = parseInt(input.value);

            if (isNaN(newStock) || newStock < 0) {
                alert('Please enter a valid stock quantity (0 or greater)');
                return;
            }

            fetch(`/stock-manager/stocks/${productId}/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ stock: newStock })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the display
                    const stockDisplay = document.getElementById(`stock-display-${productId}`);
                    if (stockDisplay) {
                        stockDisplay.textContent = newStock;
                    }

                    // Show toast
                    showToast(`${data.product_name}: Stock updated to ${newStock}`);

                    // Refresh data
                    refreshData();

                    // If stock is now > 10, fade out the item
                    if (newStock > 10) {
                        const item = document.getElementById(`low-stock-${productId}`);
                        if (item) {
                            item.style.opacity = '0.5';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 500);
                        }
                    }
                } else {
                    alert('Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating stock');
            });
        }

        // Update stock for out of stock products
        function updateStockOut(productId) {
            const input = document.getElementById(`stock-input-out-${productId}`);
            const newStock = parseInt(input.value);

            if (isNaN(newStock) || newStock < 0) {
                alert('Please enter a valid stock quantity (0 or greater)');
                return;
            }

            if (newStock === 0) {
                alert('Please enter a quantity greater than 0 to add stock');
                return;
            }

            fetch(`/stock-manager/stocks/${productId}/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ stock: newStock })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show toast
                    showToast(`${data.product_name}: Stock added (${newStock} items)`);

                    // Refresh data
                    refreshData();

                    // Fade out the item since it's no longer out of stock
                    const item = document.getElementById(`out-stock-${productId}`);
                    if (item) {
                        item.style.opacity = '0.5';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 500);
                    }
                } else {
                    alert('Failed to update stock');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating stock');
            });
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            toastMessage.textContent = message;
            toast.classList.remove('translate-y-full', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-full', 'opacity-0');
            }, 3000);
        }

        // Auto-refresh every 30 seconds
        setInterval(refreshData, 30000);
    </script>
</x-admin-layout>
