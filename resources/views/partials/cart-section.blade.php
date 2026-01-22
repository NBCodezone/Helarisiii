<!-- Cart Page Start -->
<div class="container-fluid py-5" style="background: linear-gradient(to bottom, #fff 0%, #f0fdf4 100%);">
    <div class="container py-5">
        @if($cartItems->isEmpty())
            <!-- Empty Cart State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart" style="font-size: 5rem; color: #ddd;"></i>
                </div>
                <h3 class="mb-3" style="font-family: 'Playfair Display', serif; color: #2c3e50;">Your Cart is Empty</h3>
                <p class="text-muted mb-4">Start shopping and add items to your cart!</p>
                <a href="{{ route('home') }}" class="btn btn-lg px-5 py-3"
                   style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
                          color: white;
                          border: none;
                          border-radius: 30px;
                          font-weight: 600;">
                    <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 100px;">Image</th>
                            <th scope="col" style="font-family: 'Playfair Display', serif;">Product Name</th>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 150px;">Category</th>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 120px;">Price</th>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 150px;">Quantity</th>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 120px;">Total</th>
                            <th scope="col" class="text-center" style="font-family: 'Playfair Display', serif; width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="cart-item" data-cart-id="{{ $item->id }}">
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        @if($item->product->image)
                                            <img src="{{ asset($item->product->image) }}"
                                                 alt="{{ $item->product->product_name }}"
                                                 class="img-fluid rounded shadow-sm"
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light rounded"
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-muted fa-2x"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 fw-bold" style="font-family: 'Rubik', sans-serif; color: #2c3e50;">
                                        {{ $item->product->product_name }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <span class="badge px-3 py-2" style="background: rgba(22, 163, 74, 0.1); color: var(--bs-primary); font-size: 0.85rem;">
                                        {{ $item->product->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($item->product->has_discount)
                                        <p class="mb-0" style="text-decoration: line-through; color: #999; font-size: 0.85rem;">
                                            ¥{{ number_format($item->product->price, 0) }}
                                        </p>
                                        <p class="mb-0" style="color: var(--bs-primary); font-weight: 600; font-size: 1.1rem;">
                                            ¥{{ number_format($item->product->discounted_price, 0) }}
                                        </p>
                                        <span class="badge bg-danger" style="font-size: 0.7rem;">-{{ $item->product->discount_percentage }}%</span>
                                    @else
                                        <p class="mb-0" style="color: var(--bs-primary); font-weight: 600; font-size: 1.1rem;">
                                            ¥{{ number_format($item->product->price, 0) }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="input-group" style="width: 130px;">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    onclick="updateQuantity({{ $item->id }}, -1, {{ $item->product->stock }})"
                                                    type="button"
                                                    style="border-radius: 5px 0 0 5px;">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text"
                                                   id="quantity-{{ $item->id }}"
                                                   class="form-control text-center border-secondary"
                                                   value="{{ $item->quantity }}"
                                                   readonly
                                                   style="border-left: 0; border-right: 0;">
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    onclick="updateQuantity({{ $item->id }}, 1, {{ $item->product->stock }})"
                                                    type="button"
                                                    style="border-radius: 0 5px 5px 0;">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($item->product->has_discount)
                                        <p class="mb-0" style="text-decoration: line-through; color: #999; font-size: 0.85rem;">
                                            ¥{{ number_format($item->product->price * $item->quantity, 0) }}
                                        </p>
                                    @endif
                                    <p class="mb-0 item-total fw-bold" id="item-total-{{ $item->id }}"
                                       style="color: var(--bs-primary); font-size: 1.2rem;">
                                        ¥{{ number_format($item->product->discounted_price * $item->quantity, 0) }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <form id="delete-cart-form-{{ $item->id }}" class="d-inline" onsubmit="return false;">
                                        <button type="button"
                                                onclick="removeFromCart({{ $item->id }})"
                                                class="btn btn-sm btn-outline-danger rounded-circle"
                                                style="width: 40px; height: 40px;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <a href="{{ route('home') }}" class="btn btn-lg px-4 py-3 me-3"
                   style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
                          color: white;
                          border: none;
                          border-radius: 30px;
                          font-weight: 600;">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
            </div>

            <div class="row g-4 justify-content-end mt-4">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-white rounded-3 shadow-sm">
                        <div class="p-4">
                            <h3 class="mb-4" style="font-family: 'Playfair Display', serif; color: #2c3e50;">
                                Cart <span class="fw-normal">Total</span>
                            </h3>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0 fw-bold" id="cart-subtotal" style="color: #2c3e50;">¥{{ number_format($subtotal, 0) }}</p>
                            </div>
                            <div class="d-flex justify-content-between mb-0">
                                <h4 class="mb-0 me-4" style="color: var(--bs-primary);">Total:</h4>
                                <p class="mb-0 fw-bold" id="cart-total" style="color: var(--bs-primary); font-size: 1.3rem;">¥{{ number_format($subtotal, 0) }}</p>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <a href="{{ route('checkout') }}" class="btn w-100 py-3 text-uppercase"
                               style="background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
                                      color: white;
                                      border: none;
                                      border-radius: 10px;
                                      font-weight: 600;">
                                <i class="fas fa-lock me-2"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- Cart Page End -->

<script>
    let cartIdToDelete = null;

    function setDeleteCartId(cartId) {
        cartIdToDelete = cartId;
    }

    // Override the confirmDelete function from delete modal
    function confirmDelete() {
        console.log('confirmDelete called with cartIdToDelete:', cartIdToDelete);
        if (cartIdToDelete) {
            removeFromCart(cartIdToDelete);
            cartIdToDelete = null;
            closeDeleteModal();
        } else {
            console.error('No cartIdToDelete set');
            closeDeleteModal();
        }
    }

    function updateQuantity(cartId, change, maxStock) {
        const quantityInput = document.getElementById(`quantity-${cartId}`);
        let currentQuantity = parseInt(quantityInput.value);
        let newQuantity = currentQuantity + change;

        if (newQuantity < 1) {
            return;
        }

        if (newQuantity > maxStock) {
            showNotification(`Only ${maxStock} items available in stock`, 'error');
            return;
        }

        fetch(`/cart/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                quantityInput.value = newQuantity;
                document.getElementById(`item-total-${cartId}`).textContent = `¥${data.subtotal}`;
                document.getElementById('cart-subtotal').textContent = `¥${data.cart_subtotal}`;
                document.getElementById('cart-total').textContent = `¥${data.cart_subtotal}`;
                showNotification('Cart updated successfully', 'success');
            } else {
                showNotification(data.message || 'Failed to update cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }

    function removeFromCart(cartId) {
        console.log('Removing cart item:', cartId);

        fetch(`/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.success) {
                showNotification(data.message, 'success');

                const row = document.querySelector(`tr[data-cart-id="${cartId}"]`);
                console.log('Found row:', row);

                if (row) {
                    // Add fade out animation
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'scale(0.95)';

                    setTimeout(() => {
                        row.remove();
                        console.log('Row removed');

                        // Check if there are any remaining items
                        const remainingItems = document.querySelectorAll('tr.cart-item');
                        console.log('Remaining items:', remainingItems.length);

                        if (remainingItems.length === 0) {
                            // No items left, reload to show empty cart message
                            console.log('No items left, reloading...');
                            location.reload();
                        } else {
                            // Update cart subtotal
                            const subtotalElement = document.getElementById('cart-subtotal');
                            const totalElement = document.getElementById('cart-total');

                            if (subtotalElement && totalElement) {
                                console.log('Updating subtotal and total:', data.subtotal);
                                subtotalElement.textContent = `¥${data.subtotal}`;
                                totalElement.textContent = `¥${data.subtotal}`;
                            } else {
                                console.error('Subtotal or total element not found');
                            }
                        }
                    }, 300);
                }
            } else {
                console.error('Remove failed:', data.message);
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing cart item:', error);
            showNotification('An error occurred', 'error');
        });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease;';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .cart-item {
        transition: all 0.3s ease;
    }

    .table thead th {
        background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
        color: white;
        padding: 15px;
        font-weight: 600;
        border: none;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:hover {
        background-color: #f0fdf4;
        transition: background-color 0.3s ease;
    }

    .table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
    }

    .input-group .btn {
        padding: 0.375rem 0.5rem;
    }

    .input-group input {
        max-width: 50px;
        padding: 0.375rem 0.25rem;
    }
</style>
