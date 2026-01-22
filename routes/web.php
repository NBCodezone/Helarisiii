<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Developer\SiteSettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockManagerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $rotationService = new \App\Services\FeaturedProductRotationService();
    $products = $rotationService->getFeaturedProducts();

    $carousels = \App\Models\Carousel::orderBy('order')
        ->get();

    $offers = \App\Models\ProductOffer::with('product')
        ->orderBy('order')
        ->get();

    $categories = \App\Models\Category::withCount('products')
        ->orderBy('category_name')
        ->get();

    return view('welcome', compact('products', 'carousels', 'offers', 'categories'));
})->name('home');

// Welcome route alias
Route::redirect('/welcome', '/')->name('welcome');

// Public Routes
Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/compare', function () {
    return view('compare');
})->name('compare');

// Wishlist routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/wishlist/check/{productId}', [WishlistController::class, 'check'])->name('wishlist.check');
});

// Cart routes - Available for both guest and logged-in users
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart/summary', [CartController::class, 'getSummary'])->name('cart.summary');

// User Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/notifications', [UserNotificationController::class, 'index'])->name('user.notifications');
    Route::get('/user/notifications/recent', [UserNotificationController::class, 'getRecent'])->name('user.notifications.recent');
    Route::get('/user/notifications/unread-count', [UserNotificationController::class, 'getUnreadCount'])->name('user.notifications.unreadCount');
    Route::post('/user/notifications/{id}/read', [UserNotificationController::class, 'markAsRead'])->name('user.notifications.markAsRead');
    Route::post('/user/notifications/mark-all-read', [UserNotificationController::class, 'markAllAsRead'])->name('user.notifications.markAllRead');
    Route::delete('/user/notifications/{id}', [UserNotificationController::class, 'delete'])->name('user.notifications.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [App\Http\Controllers\UserDashboardController::class, 'settings'])->name('account.settings');
    Route::put('/account/settings/update', [App\Http\Controllers\UserDashboardController::class, 'updateProfile'])->name('account.settings.update');
    Route::put('/account/password/update', [App\Http\Controllers\UserDashboardController::class, 'updatePassword'])->name('account.password.update');
});

Route::get('/search', function (Illuminate\Http\Request $request) {
    $query = $request->input('q');
    $categoryId = $request->input('category');
    
    $productsQuery = \App\Models\Product::with('category');
    
    // Search by product name or description
    if ($query) {
        $productsQuery->where(function($q) use ($query) {
            $q->where('product_name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        });
    }
    
    // Filter by category
    if ($categoryId) {
        $productsQuery->where('category_id', $categoryId);
    }
    
    $products = $productsQuery->paginate(12)->appends($request->query());
    $categories = \App\Models\Category::withCount('products')->get();
    
    return view('search', compact('products', 'categories', 'query', 'categoryId'));
})->name('search');

// Categories Page - Show all categories with images
Route::get('/categories', function () {
    $categories = \App\Models\Category::withCount('products')->paginate(20);
    return view('categories', compact('categories'));
})->name('categories');

// Shop and Product Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{id}', function ($id) {
    $category = \App\Models\Category::findOrFail($id);
    $products = \App\Models\Product::where('category_id', $id)
        ->with('category')
        ->paginate(12);
    $categories = \App\Models\Category::withCount('products')->get();
    
    return view('category', compact('category', 'products', 'categories'));
})->name('category');

// Page Routes
Route::get('/single/{id?}', [ProductController::class, 'show'])->name('single');
Route::get('/bestseller', function () {
    // Get top 10 bestselling products based on completed/delivered orders
    $bestsellerProducts = \App\Models\Product::select('products.*')
        ->selectRaw('SUM(order_items.quantity) as total_sold')
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', function ($join) {
            $join->on('order_items.order_id', '=', 'orders.id')
                ->whereIn('orders.status', ['completed', 'delivered']);
        })
        ->with(['category', 'offer'])
        ->groupBy('products.id')
        ->havingRaw('SUM(order_items.quantity) > 0')
        ->orderByDesc('total_sold')
        ->limit(10)
        ->get();

    return view('bestseller', compact('bestsellerProducts'));
})->name('bestseller');

// Checkout Routes - Available for both guest and logged-in users
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [OrderController::class, 'process'])->name('checkout.process');
Route::get('/order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/{orderId}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice.download');
Route::get('/order/{orderId}/invoice/preview', function($orderId) {
    $order = \App\Models\Order::with(['items.product', 'region'])->findOrFail($orderId);
    return view('invoices.order-invoice', compact('order'));
})->name('order.invoice.preview');

// User Orders - Only for logged-in users
Route::middleware(['auth'])->group(function () {
    Route::get('/user/orders', [OrderController::class, 'userOrders'])->name('user.orders');
});
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/returns', function () {
    return view('returns');
})->name('returns');
Route::get('/delivery', function () {
    return view('delivery');
})->name('delivery');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/warranty', function () {
    return view('warranty');
})->name('warranty');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');
Route::get('/sitemap', function () {
    return view('sitemap');
})->name('sitemap');
Route::get('/testimonials', function () {
    return view('testimonials');
})->name('testimonials');
Route::get('/brands', function () {
    return view('brands');
})->name('brands');
Route::get('/vouchers', function () {
    return view('vouchers');
})->name('vouchers');
Route::get('/affiliates', function () {
    return view('affiliates');
})->name('affiliates');

// Order and User Routes
Route::get('/order/history', function () {
    return view('order-history');
})->middleware(['auth'])->name('order.history');
Route::get('/track', function () {
    return view('track');
})->name('track');
Route::get('/unsubscribe', function () {
    return view('unsubscribe');
})->name('unsubscribe');

// Action Routes
Route::post('/newsletter/subscribe', function () {
    return redirect()->back()->with('success', 'Subscribed to newsletter!');
})->name('newsletter.subscribe');
Route::get('/compare/add/{id}', function () {
    return redirect()->back()->with('success', 'Added to compare!');
})->name('compare.add');

// Seller Route
Route::get('/seller/login', function () {
    return view('seller-login');
})->name('seller.login');

// Temporary admin login route (for testing without Vite)
Route::get('/admin-login', function () {
    $user = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($user) {
        auth()->login($user);
        return redirect('/admin/products');
    }
    return 'Admin user not found';
})->name('admin.login.temp');

// Temporary order manager login route (for testing)
Route::get('/order-manager-login', function () {
    $user = \App\Models\User::where('email', 'order@example.com')->first();
    if ($user) {
        auth()->login($user);
        return redirect('/order-manager/regions');
    }
    return 'Order manager user not found';
})->name('order-manager.login.temp');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Role-based dashboards
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])
        ->middleware('role:user')
        ->name('user.dashboard');

    Route::get('/developer/dashboard', function () {
        return view('developer-dashboard');
    })->middleware('role:developer')->name('developer.dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin-dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/order-manager/dashboard', [StockManagerController::class, 'dashboard'])
        ->middleware('role:order_manager')
        ->name('order-manager.dashboard');
});

// Stock Manager Routes - Protected by stock_manager middleware
Route::middleware(['auth', 'stock_manager'])->prefix('stock-manager')->name('stock-manager.')->group(function () {
    Route::get('dashboard', [StockManagerController::class, 'stockDashboard'])->name('dashboard');

    // Stock Notifications
    Route::post('notifications/{id}/read', [StockManagerController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [StockManagerController::class, 'markAllNotificationsAsRead'])->name('notifications.read-all');
    Route::delete('notifications/{id}', [StockManagerController::class, 'deleteNotification'])->name('notifications.delete');
    Route::get('stock-data', [StockManagerController::class, 'getStockData'])->name('stock-data');
    Route::get('notifications/unread', [StockManagerController::class, 'getUnreadNotifications'])->name('notifications.unread');

    // Stock Management
    Route::get('stocks', [StockManagerController::class, 'stockIndex'])->name('stocks.index');
    Route::post('stocks/{id}/update', [StockManagerController::class, 'updateStock'])->name('stocks.update');
    Route::post('stocks/bulk-update', [StockManagerController::class, 'bulkUpdateStock'])->name('stocks.bulk-update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Protected by admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class);
    Route::resource('carousels', \App\Http\Controllers\Admin\CarouselController::class)->except(['show']);
    Route::resource('offers', \App\Http\Controllers\Admin\ProductOfferController::class)->except(['show']);
    Route::get('orders', [OrderController::class, 'adminOrders'])->name('orders');
    Route::post('orders/{orderId}/approve', [OrderController::class, 'approveOrder'])->name('orders.approve');
    Route::post('orders/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Bank Account Routes
    Route::resource('bank-accounts', \App\Http\Controllers\Admin\BankAccountController::class)->except(['show']);
    Route::post('bank-accounts/{bank_account}/activate', [\App\Http\Controllers\Admin\BankAccountController::class, 'activate'])->name('bank-accounts.activate');

    // Featured Product Rotation Routes
    Route::get('featured-rotation', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'index'])->name('featured-rotation.index');
    Route::post('featured-rotation/settings', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'updateSettings'])->name('featured-rotation.update-settings');
    Route::post('featured-rotation/force', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'forceRotation'])->name('featured-rotation.force');
    Route::post('featured-rotation/reset', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'resetRotation'])->name('featured-rotation.reset');
    Route::get('featured-rotation/groups', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'groups'])->name('featured-rotation.groups');
    Route::get('featured-rotation/groups/create', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'createGroup'])->name('featured-rotation.groups.create');
    Route::post('featured-rotation/groups', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'storeGroup'])->name('featured-rotation.groups.store');
    Route::get('featured-rotation/groups/{id}/edit', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'editGroup'])->name('featured-rotation.groups.edit');
    Route::put('featured-rotation/groups/{id}', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'updateGroup'])->name('featured-rotation.groups.update');
    Route::delete('featured-rotation/groups/{id}', [\App\Http\Controllers\Admin\FeaturedProductRotationController::class, 'destroyGroup'])->name('featured-rotation.groups.destroy');

    // Customer Management Routes
    Route::get('customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::delete('customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

    // Analytics Routes
    Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/products', [\App\Http\Controllers\Admin\AnalyticsController::class, 'products'])->name('analytics.products');

    // Contact Messages Routes
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    // Stock Management (Admin)
    Route::get('stocks', [StockManagerController::class, 'stockIndex'])->name('stocks.index');
    Route::post('stocks/{id}/update', [StockManagerController::class, 'updateStock'])->name('stocks.update');
    Route::post('stocks/bulk-update', [StockManagerController::class, 'bulkUpdateStock'])->name('stocks.bulk-update');
});

// Developer Routes - Protected by developer middleware (same features as admin but different path)
Route::middleware(['auth', 'developer'])->prefix('developer')->name('developer.')->group(function () {
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class);
    Route::resource('carousels', \App\Http\Controllers\Admin\CarouselController::class)->except(['show']);
    Route::resource('offers', \App\Http\Controllers\Admin\ProductOfferController::class)->except(['show']);
    Route::get('orders', [OrderController::class, 'adminOrders'])->name('orders');
    Route::post('orders/{orderId}/approve', [OrderController::class, 'approveOrder'])->name('orders.approve');
    Route::post('orders/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('site-settings/maintenance', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings/maintenance', [SiteSettingController::class, 'update'])->name('site-settings.update');
});

// Order Manager Routes - Protected by order_manager middleware
Route::middleware(['auth', 'order_manager'])->prefix('order-manager')->name('order-manager.')->group(function () {
    // Regions and Delivery Charges
    Route::resource('regions', \App\Http\Controllers\Admin\RegionController::class)->except(['show']);
    Route::resource('delivery-charges', \App\Http\Controllers\Admin\DeliveryChargeController::class)->except(['show']);
    Route::resource('shipping-discounts', \App\Http\Controllers\Admin\ShippingDiscountRuleController::class)->except(['show']);

    // Orders Management
    Route::get('orders', [OrderController::class, 'orderManagerOrders'])->name('orders');
    Route::post('orders/{orderId}/approve', [OrderController::class, 'approveOrder'])->name('orders.approve');
    Route::post('orders/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

// API Routes for AJAX calls
Route::get('/api/delivery-charges/{regionId}', [OrderController::class, 'getDeliveryCharges']);
Route::get('/api/all-delivery-charges', [OrderController::class, 'getAllDeliveryCharges']);
Route::post('/api/calculate-shipping-discount', [OrderController::class, 'calculateShippingDiscount']);
Route::post('/api/check-free-shipping-availability', [OrderController::class, 'checkFreeShippingAvailability']);

require __DIR__.'/auth.php';

