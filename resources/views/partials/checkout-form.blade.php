<!-- Checkout Form Section Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Billing Details</h1>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

      

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="delivery_charge_id" id="delivery_charge_id" value="">
            @php
                $hasFrozen = $cartItems->contains(function ($item) {
                    return $item->product && $item->product->is_frozen;
                });
            @endphp
            <input type="hidden" id="frozen_weight" value="{{ $hasFrozen ? 1 : 0 }}">
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">First Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item w-100">
                                <label class="form-label my-3">Last Name<sup>*</sup></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">Email Address<sup>*</sup></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item">
                                <label class="form-label my-3">Mobile Number</label>
                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="+81 90-1234-5678">
                                <!-- <small class="text-muted">Japan mobile number format: +81 XX-XXXX-XXXX</small> -->
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-item">
                                <label class="form-label my-3">WhatsApp Number</label>
                                <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="+81 90-1234-5678">
                                <!-- <small class="text-muted">WhatsApp number (international format)</small> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-item">
                        <small class="text-info"><i class="fas fa-info-circle"></i> At least one contact number (Mobile or WhatsApp) is required</small>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">Postal Code<sup>*</sup></label>
                        <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="123-4567" maxlength="8" required>
                        <small class="text-muted">Format: XXX-XXXX (7 digits)</small>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">Ken (Prefecture)<sup>*</sup></label>
                        <select class="form-select" name="ken_name" id="ken_name" required>
                            <option value="">Select Ken</option>
                        </select>
                        <small class="text-muted">Search by typing the ken name</small>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">City<sup>*</sup></label>
                        <input type="text" class="form-control" name="city" value="{{ old('city') }}" placeholder="Enter city name" required>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">Apartment/House No., Street<sup>*</sup></label>
                        <textarea class="form-control" name="apartment" rows="3" required>{{ old('apartment') }}</textarea>
                    </div>

                    <div class="form-item">
                        <label class="form-label my-3">Payment Method<sup>*</sup></label>
                        <select class="form-select" name="payment_method" id="payment_method" required>
                            <option value="">Select Payment Method</option>
                            @php
                                $cartSubtotal = $cartItems->sum(function ($item) {
                                    return $item->product->discounted_price * $item->quantity;
                                });
                                $codMinimum = 5000;
                                $isCodAvailable = $cartSubtotal >= $codMinimum;
                            @endphp
                            <option value="cash_on_delivery" 
                                    {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}
                                    {{ !$isCodAvailable ? 'disabled' : '' }}>
                                Cash on Delivery {{ !$isCodAvailable ? '(Min. ¥' . number_format($codMinimum) . ' required)' : '' }}
                            </option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @if(!$isCodAvailable)
                            <small class="text-warning d-block mt-2">
                                <i class="fas fa-info-circle"></i> Cash on Delivery requires a minimum order of ¥{{ number_format($codMinimum) }}. 
                                Your current subtotal is ¥{{ number_format($cartSubtotal) }}. 
                                Add ¥{{ number_format($codMinimum - $cartSubtotal) }} more or select Bank Transfer.
                            </small>
                        @else
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Cash on Delivery is available for orders ¥{{ number_format($codMinimum) }} and above.
                            </small>
                        @endif
                    </div>

                    <div id="bank_transfer_section" class="form-item" style="display: none;">
                        @if($activeBankAccount)
                            <div class="alert alert-info">
                                <h5>Bank Transfer Details</h5>
                                <p class="mb-2"><strong>Bank:</strong> {{ $activeBankAccount->bank_name }}</p>
                                <p class="mb-2"><strong>Account Number:</strong> {{ $activeBankAccount->account_number }}</p>
                                <p class="mb-2"><strong>Account Holder:</strong> {{ $activeBankAccount->account_holder_name }}</p>
                                @if($activeBankAccount->branch_name)
                                    <p class="mb-2"><strong>Branch:</strong> {{ $activeBankAccount->branch_name }}</p>
                                @endif
                                @if($activeBankAccount->swift_code)
                                    <p class="mb-2"><strong>SWIFT Code:</strong> {{ $activeBankAccount->swift_code }}</p>
                                @endif
                                @if($activeBankAccount->ifsc_code)
                                    <p class="mb-2"><strong>IFSC Code:</strong> {{ $activeBankAccount->ifsc_code }}</p>
                                @endif
                                @if($activeBankAccount->additional_info)
                                    <p class="mb-2"><strong>Note:</strong> {{ $activeBankAccount->additional_info }}</p>
                                @endif
                                <p class="mb-0 mt-3"><small>Please upload your payment receipt after completing the transfer.</small></p>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p class="mb-0">No active bank account configured. Please contact support for payment details.</p>
                            </div>
                        @endif
                        <label class="form-label my-3">Upload Payment Receipt<sup>*</sup></label>
                        <input type="file" class="form-control" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf">
                        <small class="text-muted">Accepted formats: JPG, PNG, PDF (Max 2MB)</small>
                    </div>

                    <!-- Delivery Date & Time Slot Section -->
                    <div class="delivery-schedule-section mt-4 p-3 border rounded bg-light">
                        <h5 class="mb-3"><i class="fas fa-calendar-alt text-primary me-2"></i>Preferred Delivery Schedule</h5>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-item">
                                    <label class="form-label my-2">Delivery Date<sup>*</sup></label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="delivery_date" 
                                           id="delivery_date" 
                                           value="{{ old('delivery_date') }}" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           required>
                                    <small class="text-muted">Select the date you want to receive your order</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-item">
                                    <label class="form-label my-2">Time Slot<sup>*</sup></label>
                                    <select class="form-select" name="delivery_time_slot" id="delivery_time_slot" required>
                                        <option value="">Select Time Slot</option>
                                        <option value="8-12" {{ old('delivery_time_slot') == '8-12' ? 'selected' : '' }}>8:00 AM - 12:00 PM</option>
                                        <option value="12-14" {{ old('delivery_time_slot') == '12-14' ? 'selected' : '' }}>12:00 PM - 2:00 PM</option>
                                        <option value="14-16" {{ old('delivery_time_slot') == '14-16' ? 'selected' : '' }}>2:00 PM - 4:00 PM</option>
                                        <option value="16-18" {{ old('delivery_time_slot') == '16-18' ? 'selected' : '' }}>4:00 PM - 6:00 PM</option>
                                        <option value="18-20" {{ old('delivery_time_slot') == '18-20' ? 'selected' : '' }}>6:00 PM - 8:00 PM</option>
                                        <option value="19-21" {{ old('delivery_time_slot') == '19-21' ? 'selected' : '' }}>7:00 PM - 9:00 PM</option>
                                    </select>
                                    <small class="text-muted">Choose your preferred time slot for delivery</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Products</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                    $totalDiscount = 0;
                                @endphp
                                @foreach($cartItems as $item)
                                    @php
                                        $originalPrice = $item->product->price;
                                        $discountedPrice = $item->product->discounted_price;
                                        $hasDiscount = $item->product->has_discount;
                                        $discountPercent = $item->product->discount_percentage;
                                        $itemTotal = $discountedPrice * $item->quantity;
                                        $itemDiscount = ($originalPrice - $discountedPrice) * $item->quantity;
                                        $subtotal += $itemTotal;
                                        $totalDiscount += $itemDiscount;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center mt-2 position-relative">
                                                <img src="{{ asset($item->product->image) }}"
                                                     class="img-fluid rounded-circle"
                                                     style="width: 90px; height: 90px;"
                                                     alt="{{ $item->product->product_name }}"
                                                     onerror="this.src='{{ asset('Electro-Bootstrap-1.0.0/img/product-3.png') }}'">
                                                @if($hasDiscount)
                                                    <span class="badge bg-danger position-absolute" style="top: 0; right: 0; font-size: 10px;">-{{ $discountPercent }}%</span>
                                                @endif
                                            </div>
                                        </th>
                                        <td class="py-5">
                                            {{ $item->product->product_name }}
                                            @if($hasDiscount)
                                                <br><small class="text-success"><i class="fas fa-tag"></i> {{ $discountPercent }}% OFF</small>
                                            @endif
                                        </td>
                                        <td class="py-5">
                                            @if($hasDiscount)
                                                <span style="text-decoration: line-through; color: #999; font-size: 12px;">¥{{ number_format($originalPrice, 0) }}</span><br>
                                                <span class="text-success fw-bold">¥{{ number_format($discountedPrice, 0) }}</span>
                                            @else
                                                ¥{{ number_format($originalPrice, 0) }}
                                            @endif
                                        </td>
                                        <td class="py-5">{{ $item->quantity }}</td>
                                        <td class="py-5">
                                            @if($hasDiscount)
                                                <span style="text-decoration: line-through; color: #999; font-size: 12px;">¥{{ number_format($originalPrice * $item->quantity, 0) }}</span><br>
                                                <span class="text-success fw-bold">¥{{ number_format($itemTotal, 0) }}</span>
                                            @else
                                                ¥{{ number_format($itemTotal, 0) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $orderTaxRate = $taxRate ?? 0;
                                    $taxAmount = round($subtotal * $orderTaxRate, 2);
                                    $taxPercentageLabel = rtrim(rtrim(number_format($orderTaxRate * 100, 2), '0'), '.');
                                    $taxPercentageLabel = $taxPercentageLabel === '' ? '0' : $taxPercentageLabel;
                                    $initialTotal = $subtotal + $taxAmount;
                                @endphp
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Subtotal</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="subtotal">¥{{ number_format($subtotal, 0) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @if($totalDiscount > 0)
                                <tr id="product_discount_row">
                                    <th scope="row"></th>
                                    <td class="py-3"></td>
                                    <td class="py-3"></td>
                                    <td class="py-3">
                                        <p class="mb-0 text-success py-2"><i class="fas fa-tag"></i> Product Discounts</p>
                                    </td>
                                    <td class="py-3">
                                        <div class="py-2 border-bottom border-top">
                                            <p class="mb-0 text-success fw-bold" id="product_discount">-¥{{ number_format($totalDiscount, 0) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Tax ({{ $taxPercentageLabel }}%)</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="tax_amount">¥{{ number_format($taxAmount, 0) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Delivery Charge</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="delivery_charge">¥0</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="shipping_discount_info" style="display: none;">
                                    <td class="py-2"></td>
                                    <td class="py-2"></td>
                                    <td class="py-2">
                                        <p class="mb-0 text-success" style="font-size: 0.9em;">
                                            <i class="fas fa-tag"></i> Shipping Discount
                                        </p>
                                    </td>
                                    <td class="py-2">
                                        <p class="mb-0 text-success" style="font-size: 0.9em; font-weight: bold;" id="shipping_discount_text"></p>
                                    </td>
                                </tr>
                                @php
                                    // Check if cart contains any frozen items
                                    $hasFrozenItems = $cartItems->contains(function ($item) {
                                        return $item->product && $item->product->is_frozen;
                                    });

                                    // Calculate frozen charge based on box configuration
                                    $frozenCharge = 0;
                                    if ($hasFrozenItems) {
                                        // If weight <= 10kg: use 1 small box → frozen cost = ¥670
                                        if ($totalWeight <= 10) {
                                            $frozenCharge = 670;
                                        }
                                        // If weight 10-24kg: use 1 large box → frozen cost = ¥870
                                        elseif ($totalWeight <= 24) {
                                            $frozenCharge = 870;
                                        }
                                        // If weight > 24kg: calculate box configuration
                                        else {
                                            $largeBoxes = floor($totalWeight / 24);
                                            $remainingWeight = $totalWeight - ($largeBoxes * 24);

                                            // If remaining weight fits in small box (0-10kg) → frozen cost = ¥670
                                            if ($remainingWeight > 0 && $remainingWeight <= 10) {
                                                $frozenCharge = 670;
                                            } else {
                                                // Otherwise, using only large boxes → frozen cost = ¥870
                                                $frozenCharge = 870;
                                            }
                                        }
                                    }
                                @endphp
                                <tr id="frozen_charge_row" style="{{ ($frozenCharge ?? 0) > 0 ? '' : 'display:none;' }}">
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Frozen Item Charge</p>
                                        <small class="text-muted">(Total order: {{ number_format($totalWeight, 2) }}kg)</small>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="frozen_charge">¥{{ number_format($frozenCharge ?? 0, 0) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="py-3 border-bottom border-top">
                                            <p class="mb-0 text-dark" id="total_amount">¥{{ number_format($initialTotal, 0) }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Free Shipping Progress Bar Section -->
                    <div id="free_shipping_progress_container" class="free-shipping-progress-section mt-3 mb-4" style="display: none;">
                        <div class="free-shipping-card">
                            <div class="free-shipping-header">
                                <span class="truck-icon">🚚</span>
                                <span id="free_shipping_title" class="progress-title">Free Shipping Progress</span>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-bar-container">
                                    <div id="free_shipping_progress_bar" class="progress-bar-fill" style="width: 0%;"></div>
                                </div>
                                <div id="free_shipping_percentage" class="progress-percentage">0%</div>
                            </div>
                            <p id="free_shipping_message" class="progress-message">
                                Add more items to unlock free shipping!
                            </p>
                            
                            <!-- Celebration Container (hidden by default) -->
                            <div id="celebration_container" class="celebration-container" style="display: none;">
                                <div class="gift-animation">
                                    <span class="gift-icon">🎁</span>
                                    <span class="gift-text">Free Shipping Unlocked!</span>
                                </div>
                                <div class="confetti-container" id="confetti_container"></div>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Free Shipping Progress Bar Styles */
                        .free-shipping-progress-section {
                            animation: slideIn 0.3s ease-out;
                        }
                        
                        @keyframes slideIn {
                            from {
                                opacity: 0;
                                transform: translateY(-10px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                        
                        .free-shipping-card {
                            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                            border: 2px solid #dee2e6;
                            border-radius: 16px;
                            padding: 20px;
                            position: relative;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        }
                        
                        .free-shipping-card:hover {
                            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                        }
                        
                        .free-shipping-card.qualified {
                            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                            border-color: #28a745;
                        }
                        
                        .free-shipping-header {
                            display: flex;
                            align-items: center;
                            margin-bottom: 15px;
                        }
                        
                        .truck-icon {
                            font-size: 28px;
                            margin-right: 12px;
                            animation: bounce 1.5s ease infinite;
                        }
                        
                        @keyframes bounce {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-5px); }
                        }
                        
                        .progress-title {
                            font-weight: 700;
                            font-size: 16px;
                            color: #333;
                        }
                        
                        .progress-wrapper {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        }
                        
                        .progress-bar-container {
                            flex: 1;
                            height: 24px;
                            background: #e0e0e0;
                            border-radius: 12px;
                            overflow: hidden;
                            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
                            position: relative;
                        }
                        
                        .progress-bar-fill {
                            height: 100%;
                            background: linear-gradient(90deg, #ff9800, #ff5722);
                            border-radius: 12px;
                            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                            position: relative;
                            overflow: hidden;
                        }
                        
                        .progress-bar-fill::after {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background: linear-gradient(
                                90deg,
                                rgba(255, 255, 255, 0) 0%,
                                rgba(255, 255, 255, 0.3) 50%,
                                rgba(255, 255, 255, 0) 100%
                            );
                            animation: shimmer 2s infinite;
                        }
                        
                        @keyframes shimmer {
                            0% { transform: translateX(-100%); }
                            100% { transform: translateX(100%); }
                        }
                        
                        .progress-bar-fill.complete {
                            background: linear-gradient(90deg, #28a745, #20c997);
                        }
                        
                        .progress-percentage {
                            font-weight: 800;
                            font-size: 18px;
                            min-width: 55px;
                            text-align: right;
                            color: #ff5722;
                            transition: color 0.3s ease;
                        }
                        
                        .progress-percentage.complete {
                            color: #28a745;
                        }
                        
                        .progress-message {
                            margin-top: 12px;
                            font-size: 14px;
                            color: #666;
                            margin-bottom: 0;
                            text-align: center;
                        }
                        
                        .progress-message.complete {
                            color: #28a745;
                            font-weight: 600;
                        }
                        
                        /* Celebration Animation */
                        .celebration-container {
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            pointer-events: none;
                            z-index: 10;
                        }
                        
                        .gift-animation {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            animation: giftPop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                        }
                        
                        @keyframes giftPop {
                            0% {
                                transform: translate(-50%, -50%) scale(0);
                                opacity: 0;
                            }
                            50% {
                                transform: translate(-50%, -50%) scale(1.2);
                            }
                            100% {
                                transform: translate(-50%, -50%) scale(1);
                                opacity: 1;
                            }
                        }
                        
                        .gift-icon {
                            font-size: 48px;
                            animation: shake 0.5s ease-in-out infinite;
                        }
                        
                        @keyframes shake {
                            0%, 100% { transform: rotate(0deg); }
                            25% { transform: rotate(-10deg); }
                            75% { transform: rotate(10deg); }
                        }
                        
                        .gift-text {
                            font-weight: 800;
                            font-size: 16px;
                            color: #28a745;
                            margin-top: 8px;
                            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            background: linear-gradient(135deg, #28a745, #20c997);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                        }
                        
                        /* Confetti Particles */
                        .confetti-particle {
                            position: absolute;
                            width: 10px;
                            height: 10px;
                            opacity: 0;
                            animation: confettiFall 3s ease-out forwards;
                        }
                        
                        @keyframes confettiFall {
                            0% {
                                transform: translateY(-20px) rotate(0deg);
                                opacity: 1;
                            }
                            100% {
                                transform: translateY(100px) rotate(720deg);
                                opacity: 0;
                            }
                        }
                        
                        /* Amount Display in Progress Bar */
                        .amount-display {
                            display: flex;
                            justify-content: space-between;
                            margin-top: 8px;
                            font-size: 12px;
                            color: #888;
                        }
                        
                        .amount-current {
                            font-weight: 600;
                            color: #ff5722;
                        }
                        
                        .amount-target {
                            font-weight: 600;
                            color: #28a745;
                        }
                        
                        /* Responsive adjustments */
                        @media (max-width: 576px) {
                            .free-shipping-card {
                                padding: 15px;
                            }
                            
                            .gift-icon {
                                font-size: 36px;
                            }
                            
                            .gift-text {
                                font-size: 14px;
                            }
                        }
                    </style>

                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                        <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkout Form Section End -->
