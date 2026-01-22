<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Checkout</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('Electro-Bootstrap-1.0.0/css/style.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="{{ asset('css/custom.css?v=1.1') }}" rel="stylesheet">
</head>
<body>
    @include('partials.topbar')

    @include('partials.navbar')

    @include('partials.page-header', ['title' => 'Checkout'])

    @include('partials.services')

    <!-- Checkout Section -->
    @include('partials.checkout-form')

    @include('partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Electro-Bootstrap-1.0.0/js/main.js') }}"></script>

    <!-- Initialize Template Features -->
    <script>
        // Initialize WOW.js for animations
        new WOW().init();

        $(document).ready(function() {
            console.log('Checkout page loaded');
            const cartTotalWeight = parseFloat(@json($totalWeight ?? 0)) || 0;
            console.log('Cart total weight (kg):', cartTotalWeight);
            const orderTaxRate = parseFloat(@json($taxRate ?? 0)) || 0;
            console.log('Order tax rate:', orderTaxRate);

            // COD Minimum Amount Configuration
            const COD_MINIMUM_AMOUNT = 5000; // Minimum order amount for Cash on Delivery (in yen)
            
            // Handle payment method change with COD validation
            $('#payment_method').on('change', function() {
                const paymentMethod = $(this).val();
                console.log('Payment method changed:', paymentMethod);

                if (paymentMethod === 'bank_transfer') {
                    $('#bank_transfer_section').slideDown();
                    $('#cod_warning_section').slideUp();
                    $('button[type="submit"]').prop('disabled', false);
                } else if (paymentMethod === 'cash_on_delivery') {
                    $('#bank_transfer_section').slideUp();
                    $('#payment_receipt').val('');
                    // Check COD minimum amount
                    validateCODMinimum();
                } else {
                    $('#bank_transfer_section').slideUp();
                    $('#payment_receipt').val('');
                    $('#cod_warning_section').slideUp();
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
            
            // Validate COD minimum amount requirement
            function validateCODMinimum() {
                const subtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;
                const paymentMethod = $('#payment_method').val();
                
                console.log('Validating COD - Subtotal:', subtotal, 'Minimum:', COD_MINIMUM_AMOUNT);
                
                if (paymentMethod === 'cash_on_delivery' && subtotal < COD_MINIMUM_AMOUNT) {
                    const remaining = COD_MINIMUM_AMOUNT - subtotal;
                    
                    // Create warning section if it doesn't exist
                    if ($('#cod_warning_section').length === 0) {
                        const warningHtml = `
                            <div id="cod_warning_section" class="alert alert-warning mt-3" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
                                    <div>
                                        <h6 class="mb-1"><strong>⚠️ Cash on Delivery Not Available</strong></h6>
                                        <p class="mb-2" id="cod_warning_message"></p>
                                        <div class="mt-2">
                                            <span class="badge bg-info me-2"><i class="fas fa-shopping-cart"></i> Add ¥<span id="cod_remaining_amount"></span> more</span>
                                            <span class="text-muted">OR</span>
                                            <span class="badge bg-success ms-2 cursor-pointer" id="switch_to_bank_transfer" style="cursor: pointer;"><i class="fas fa-university"></i> Switch to Bank Transfer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#payment_method').closest('.form-item').after(warningHtml);
                        
                        // Add click handler for switching to bank transfer
                        $(document).on('click', '#switch_to_bank_transfer', function() {
                            $('#payment_method').val('bank_transfer').trigger('change');
                        });
                    }
                    
                    // Update warning message
                    $('#cod_warning_message').html(
                        'Cash on Delivery requires a minimum order of <strong>¥' + COD_MINIMUM_AMOUNT.toLocaleString() + '</strong>. ' +
                        'Your current subtotal is <strong>¥' + subtotal.toLocaleString() + '</strong>.'
                    );
                    $('#cod_remaining_amount').text(remaining.toLocaleString());
                    
                    // Show warning and disable submit
                    $('#cod_warning_section').slideDown();
                    $('button[type="submit"]').prop('disabled', true);
                    
                    console.log('COD validation failed - Subtotal below minimum');
                } else {
                    // Hide warning and enable submit
                    $('#cod_warning_section').slideUp();
                    $('button[type="submit"]').prop('disabled', false);
                    
                    console.log('COD validation passed');
                }
            }
            
            // Trigger COD validation on page load if COD is pre-selected
            if ($('#payment_method').val() === 'cash_on_delivery') {
                validateCODMinimum();
            }

            // Load all kens on page load
            function loadAllKens() {
                const kenSelect = $('#ken_name');
                kenSelect.html('<option value="">Loading kens...</option>');

                $.ajax({
                    url: '/api/all-delivery-charges',
                    type: 'GET',
                    success: function(data) {
                        console.log('All kens loaded:', data);
                        kenSelect.html('<option value="">Select Ken</option>');

                        if (data.length > 0) {
                            data.forEach(function(deliveryCharge) {
                                kenSelect.append(
                                    $('<option></option>')
                                        .attr('value', deliveryCharge.ken_name)
                                        .attr('data-charge-10', deliveryCharge.price_0_10kg)
                                        .attr('data-charge-24', deliveryCharge.price_10_24kg)
                                        .attr('data-delivery-id', deliveryCharge.id)
                                        .attr('data-region-id', deliveryCharge.region_id)
                                        .text(deliveryCharge.ken_name)
                                );
                            });

                            // Initialize Select2 for searchable dropdown
                            kenSelect.select2({
                                placeholder: 'Search and select ken',
                                allowClear: true,
                                width: '100%'
                            });
                        } else {
                            kenSelect.html('<option value="">No kens available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading kens:', error);
                        kenSelect.html('<option value="">Error loading kens</option>');
                    }
                });
            }

            // Call loadAllKens on page load
            loadAllKens();

            // Update delivery charge when ken is selected
            $('#ken_name').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const priceTenKg = parseFloat(selectedOption.attr('data-charge-10')) || 0;
                const priceTwentyFourKg = parseFloat(selectedOption.attr('data-charge-24')) || 0;
                const deliveryId = selectedOption.attr('data-delivery-id') || '';
                const regionId = selectedOption.attr('data-region-id') || '';
                let deliveryCharge = calculateDeliveryCharge(cartTotalWeight, priceTenKg, priceTwentyFourKg);

                console.log('Ken selected, delivery charge:', deliveryCharge, ' (10kg price:', priceTenKg, ', 24kg price:', priceTwentyFourKg, ')');

                $('#delivery_charge_id').val(deliveryId);

                // Store region_id in a hidden field for form submission
                if (!$('#region_id').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'region_id',
                        name: 'region_id',
                        value: regionId
                    }).appendTo('form');
                } else {
                    $('#region_id').val(regionId);
                }

                // Check for shipping discount
                checkShippingDiscount(deliveryCharge, regionId);

                // Recalculate frozen charge based on box configuration
                const hasFrozenItems = parseFloat($('#frozen_weight').val()) || 0;
                let frozenCharge = 0;
                if (hasFrozenItems > 0) {
                    // If weight <= 10kg: use 1 small box → frozen cost = ¥670
                    if (cartTotalWeight <= 10) {
                        frozenCharge = 670;
                    }
                    // If weight 10-24kg: use 1 large box → frozen cost = ¥870
                    else if (cartTotalWeight <= 24) {
                        frozenCharge = 870;
                    }
                    // If weight > 24kg: calculate box configuration
                    else {
                        const largeBoxes = Math.floor(cartTotalWeight / 24);
                        const remainingWeight = cartTotalWeight - (largeBoxes * 24);

                        // If remaining weight fits in small box (0-10kg) → frozen cost = ¥670
                        if (remainingWeight > 0 && remainingWeight <= 10) {
                            frozenCharge = 670;
                        } else {
                            // Otherwise, using only large boxes → frozen cost = ¥870
                            frozenCharge = 870;
                        }
                    }
                    $('#frozen_charge').text('¥' + frozenCharge.toFixed(0));
                    $('#frozen_charge_row').show();
                } else {
                    $('#frozen_charge').text('¥0');
                    $('#frozen_charge_row').hide();
                }
                updateTotal();
            });

            function checkShippingDiscount(originalDeliveryCharge, regionId = null) {
                if (!regionId) {
                    regionId = $('#region_id').val();
                }
                const subtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;

                console.log('=== Checking Shipping Discount ===');
                console.log('Region ID:', regionId);
                console.log('Subtotal:', subtotal);
                console.log('Total Weight:', cartTotalWeight);
                console.log('Original Delivery Charge:', originalDeliveryCharge);

                if (!regionId || originalDeliveryCharge <= 0) {
                    console.log('Skipping discount check - no region or delivery charge is 0');
                    $('#delivery_charge').text('¥' + originalDeliveryCharge.toFixed(0));
                    $('#delivery_charge').attr('data-actual-charge', originalDeliveryCharge);
                    $('#shipping_discount_info').hide();
                    updateTotal();
                    return;
                }

                console.log('Making AJAX call to /api/calculate-shipping-discount');
                $.ajax({
                    url: '/api/calculate-shipping-discount',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        region_id: regionId,
                        subtotal: subtotal,
                        total_weight: cartTotalWeight
                    },
                    success: function(response) {
                        console.log('✅ Shipping discount API response:', response);

                        // Show detailed debug info
                        if (response.debug) {
                            console.log('📊 DEBUG INFO:', response.debug);
                            if (response.debug.rules_checked) {
                                console.table(response.debug.rules_checked);
                            }
                        }

                        if (response.has_discount) {
                            const discountPercentage = response.discount_percentage;
                            const maxWeightLimit = response.max_weight_limit;
                            const weightExceedsLimit = response.weight_exceeds_limit;
                            const excessWeight = response.excess_weight;

                            let finalCharge = 0;
                            let discountText = '';

                            if (weightExceedsLimit && discountPercentage >= 100) {
                                // Partial free shipping - calculate excess weight charge
                                const selectedOption = $('#ken_name').find(':selected');
                                const priceTenKg = parseFloat(selectedOption.attr('data-charge-10')) || 0;
                                const priceTwentyFourKg = parseFloat(selectedOption.attr('data-charge-24')) || 0;
                                
                                // Calculate charge for excess weight only
                                const excessCharge = calculateDeliveryCharge(excessWeight, priceTenKg, priceTwentyFourKg);
                                finalCharge = excessCharge;

                                // Display with explanation
                                let chargeHtml = '<span style="text-decoration: line-through; color: #999;">¥' + originalDeliveryCharge.toFixed(0) + '</span> ';
                                chargeHtml += '<span style="color: #28a745; font-weight: bold;">¥' + finalCharge.toFixed(0) + '</span>';
                                $('#delivery_charge').html(chargeHtml);

                                discountText = 'Free shipping up to ' + maxWeightLimit + 'kg';
                                if (excessWeight > 0) {
                                    discountText += ' (Excess ' + excessWeight.toFixed(1) + 'kg: ¥' + excessCharge.toFixed(0) + ')';
                                }
                            } else if (discountPercentage >= 100) {
                                // Full free shipping
                                finalCharge = 0;
                                $('#delivery_charge').html('<span style="text-decoration: line-through; color: #999;">¥' + originalDeliveryCharge.toFixed(0) + '</span> <span style="color: #28a745; font-weight: bold;">FREE</span>');
                                discountText = 'FREE SHIPPING';
                            } else {
                                // Partial discount (not 100%)
                                const discountAmount = originalDeliveryCharge * (discountPercentage / 100);
                                finalCharge = originalDeliveryCharge - discountAmount;
                                $('#delivery_charge').html('<span style="text-decoration: line-through; color: #999;">¥' + originalDeliveryCharge.toFixed(0) + '</span> <span style="color: #28a745; font-weight: bold;">¥' + finalCharge.toFixed(0) + '</span>');
                                discountText = discountPercentage + '% OFF';
                            }

                            // Store the actual charge for calculation
                            $('#delivery_charge').attr('data-actual-charge', finalCharge);

                            // Show discount info
                            if (response.rule_name) {
                                discountText += ' - ' + response.rule_name;
                            }
                            $('#shipping_discount_text').text(discountText);
                            $('#shipping_discount_info').show();
                        } else {
                            $('#delivery_charge').text('¥' + originalDeliveryCharge.toFixed(0));
                            $('#delivery_charge').attr('data-actual-charge', originalDeliveryCharge);
                            $('#shipping_discount_info').hide();
                        }

                        updateTotal();
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Error checking shipping discount');
                        console.error('Status:', status);
                        console.error('Error:', error);
                        console.error('Response:', xhr.responseText);
                        console.error('Status Code:', xhr.status);
                        $('#delivery_charge').text('¥' + originalDeliveryCharge.toFixed(0));
                        $('#delivery_charge').attr('data-actual-charge', originalDeliveryCharge);
                        $('#shipping_discount_info').hide();
                        updateTotal();
                    }
                });
            }

            function updateTotal() {
                const subtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;
                const deliveryCharge = parseFloat($('#delivery_charge').attr('data-actual-charge') || $('#delivery_charge').text().replace(/[¥,]/g, '')) || 0;
                const frozenCharge = parseFloat($('#frozen_charge').text().replace(/[¥,]/g, '')) || 0;

                // Calculate tax on subtotal only (items)
                const taxAmount = parseFloat((subtotal * orderTaxRate).toFixed(2));

                $('#tax_amount').text('¥' + taxAmount.toFixed(0));
                const total = subtotal + taxAmount + deliveryCharge + frozenCharge;
                $('#total_amount').text('¥' + total.toFixed(0));
                console.log('Total updated - Subtotal:', subtotal, 'Delivery:', deliveryCharge, 'Frozen:', frozenCharge, 'Tax (8% of subtotal):', taxAmount, 'Total:', total);
            }

            function calculateDeliveryCharge(totalWeight, priceTenKg, priceTwentyFourKg) {
                if (!totalWeight || (priceTenKg <= 0 && priceTwentyFourKg <= 0)) {
                    return 0;
                }

                // If weight is 10kg or less, use 0-10kg box
                if (totalWeight <= 10) {
                    return priceTenKg > 0 ? priceTenKg : 0;
                }

                // If weight is more than 10kg but 24kg or less, use one 10-24kg box
                if (totalWeight <= 24) {
                    return priceTwentyFourKg > 0 ? priceTwentyFourKg : 0;
                }

                // If weight is more than 24kg, use multiple 10-24kg boxes only
                // This is better for the user (e.g., 40kg = 2 boxes of 10-24kg)
                if (priceTwentyFourKg > 0) {
                    const boxCount = Math.ceil(totalWeight / 24);
                    return boxCount * priceTwentyFourKg;
                }

                return 0;
            }

            updateTotal();

            // Postal code formatting (XXX-XXXX)
            $('#postal_code').on('input', function() {
                let value = $(this).val().replace(/[^\d]/g, ''); // Remove non-digits

                if (value.length > 7) {
                    value = value.substring(0, 7);
                }

                if (value.length > 3) {
                    value = value.substring(0, 3) + '-' + value.substring(3);
                }

                $(this).val(value);
            });

            // Mobile number validation and formatting for Japan (+81)
            $('#mobile_number').on('input', function() {
                let value = $(this).val();

                // If user didn't start with +81, add it
                if (value && !value.startsWith('+81')) {
                    // Remove any existing + or country code
                    value = value.replace(/^\+?\d{1,3}[-\s]?/, '');
                    value = '+81 ' + value;
                }

                $(this).val(value);
            });

            // Validate mobile number format on blur
            $('#mobile_number').on('blur', function() {
                const value = $(this).val().trim();

                if (value && value !== '') {
                    // Japan mobile number validation: +81 followed by 10-11 digits
                    const mobilePattern = /^\+81\s?\d{1,4}-?\d{4}-?\d{4}$/;

                    if (!mobilePattern.test(value.replace(/\s/g, ''))) {
                        $(this).addClass('is-invalid');
                        if (!$(this).next('.invalid-feedback').length) {
                            $(this).after('<div class="invalid-feedback">Please enter a valid Japan mobile number (e.g., +81 90-1234-5678)</div>');
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    }
                }
            });

            // Validate postal code format on blur
            $('#postal_code').on('blur', function() {
                const value = $(this).val().trim();

                if (value) {
                    // Japan postal code validation: XXX-XXXX (7 digits total)
                    const postalPattern = /^\d{3}-\d{4}$/;

                    if (!postalPattern.test(value)) {
                        $(this).addClass('is-invalid');
                        if (!$(this).next('.invalid-feedback').length) {
                            $(this).after('<div class="invalid-feedback">Please enter a valid postal code (XXX-XXXX format, 7 digits total)</div>');
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    }
                }
            });

            // Test discount button handler
            $('#testDiscountBtn').on('click', function() {
                const regionId = $('#region_id').val();
                const subtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;

                console.log('🧪 Manual Test Triggered');
                console.log('Region ID:', regionId);
                console.log('Subtotal:', subtotal);
                console.log('Total Weight:', cartTotalWeight);

                if (!regionId) {
                    $('#testResult').html('<div class="alert alert-warning">Please select a region first!</div>').show();
                    return;
                }

                $.ajax({
                    url: '/api/calculate-shipping-discount',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        region_id: regionId,
                        subtotal: subtotal,
                        total_weight: cartTotalWeight
                    },
                    success: function(response) {
                        console.log('✅ Test Result:', response);

                        let html = '<div class="alert alert-success"><strong>Test Results:</strong><br>';
                        html += 'Region ID: ' + regionId + '<br>';
                        html += 'Subtotal: ¥' + subtotal + '<br>';
                        html += 'Weight: ' + cartTotalWeight + 'kg<br>';
                        html += 'Has Discount: ' + (response.has_discount ? 'YES ✅' : 'NO ❌') + '<br>';

                        if (response.has_discount) {
                            html += 'Discount: ' + response.discount_percentage + '%<br>';
                            html += 'Rule: ' + response.rule_name + '<br>';
                        }

                        if (response.debug) {
                            html += '<br><strong>Debug Info:</strong><br>';
                            html += 'Rice Count: ' + response.debug.rice_count + '<br>';
                            html += 'Rules Found: ' + response.debug.rules_found + '<br>';

                            if (response.debug.rules_checked) {
                                html += '<br><strong>Rule Checks:</strong><br>';
                                response.debug.rules_checked.forEach(function(rule) {
                                    html += '<br>Rule #' + rule.rule_id + ': ' + rule.rule_name + ' (' + rule.discount + ')<br>';
                                    rule.checks.forEach(function(check) {
                                        html += '&nbsp;&nbsp;' + check + '<br>';
                                    });
                                });
                            }
                        }

                        html += '</div>';
                        $('#testResult').html(html).show();
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Test Error:', error, xhr.responseText);
                        $('#testResult').html('<div class="alert alert-danger">Error: ' + error + '</div>').show();
                    }
                });
            });

            // If there's an old ken_name value (from validation error), restore it
            @if(old('ken_name'))
                setTimeout(function() {
                    $('#ken_name').val('{{ old('ken_name') }}').trigger('change');
                }, 1000);
            @endif

            // =====================================================
            // Free Shipping Progress Bar Functions
            // =====================================================
            
            let currentFreeShippingRule = null;
            let hasShownCelebration = false;
            let previouslyQualified = false;
            
            // Check for free shipping rules when region is selected
            function checkFreeShippingProgress(regionId) {
                const subtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;
                
                console.log('📦 Checking free shipping progress for region:', regionId, 'Subtotal:', subtotal);
                
                if (!regionId) {
                    $('#free_shipping_progress_container').slideUp();
                    return;
                }
                
                // Fetch free shipping rules for this region
                $.ajax({
                    url: '/api/check-free-shipping-availability',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        region_id: regionId
                    },
                    success: function(response) {
                        console.log('🎯 Free shipping availability response:', response);
                        
                        if (response.has_free_shipping_rule) {
                            currentFreeShippingRule = response.rule;
                            updateFreeShippingProgressBar(subtotal, response.rule);
                            $('#free_shipping_progress_container').slideDown();
                        } else {
                            currentFreeShippingRule = null;
                            $('#free_shipping_progress_container').slideUp();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Error checking free shipping:', error);
                        $('#free_shipping_progress_container').slideUp();
                    }
                });
            }
            
            // Update the progress bar based on current subtotal
            function updateFreeShippingProgressBar(subtotal, rule) {
                if (!rule) return;
                
                const minAmount = parseFloat(rule.min_order_amount) || 0;
                const percentage = Math.min(100, (subtotal / minAmount) * 100);
                const isQualified = subtotal >= minAmount;
                
                console.log('📊 Progress bar update - Subtotal:', subtotal, 'Min:', minAmount, 'Percentage:', percentage.toFixed(1) + '%');
                
                // Update progress bar width
                $('#free_shipping_progress_bar').css('width', percentage + '%');
                
                // Update percentage text
                $('#free_shipping_percentage').text(Math.round(percentage) + '%');
                
                // Calculate remaining amount
                const remaining = Math.max(0, minAmount - subtotal);
                
                // Update message and styling based on qualification
                if (isQualified) {
                    $('#free_shipping_progress_bar').addClass('complete');
                    $('#free_shipping_percentage').addClass('complete');
                    $('#free_shipping_message')
                        .addClass('complete')
                        .html('🎉 <strong>Congratulations!</strong> You qualify for FREE SHIPPING!');
                    $('.free-shipping-card').addClass('qualified');
                    $('#free_shipping_title').text('Free Shipping Unlocked!');
                    
                    // Show celebration animation (only once)
                    if (!previouslyQualified && !hasShownCelebration) {
                        triggerCelebration();
                        hasShownCelebration = true;
                    }
                    previouslyQualified = true;
                } else {
                    $('#free_shipping_progress_bar').removeClass('complete');
                    $('#free_shipping_percentage').removeClass('complete');
                    $('#free_shipping_message')
                        .removeClass('complete')
                        .html('Add <strong>¥' + remaining.toLocaleString() + '</strong> more to unlock <span style="color: #28a745; font-weight: bold;">FREE SHIPPING</span>! 🚚');
                    $('.free-shipping-card').removeClass('qualified');
                    $('#free_shipping_title').text('Free Shipping Progress');
                    previouslyQualified = false;
                    // Reset celebration flag when user goes below threshold
                    hasShownCelebration = false;
                }
                
                // Update weight limit info if applicable
                if (rule.max_weight_limit) {
                    $('#free_shipping_title').append(' <small style="font-size: 12px; color: #888;">(up to ' + rule.max_weight_limit + 'kg)</small>');
                }
            }
            
            // Trigger celebration animation
            function triggerCelebration() {
                const container = $('#celebration_container');
                const confettiContainer = $('#confetti_container');
                
                // Show celebration
                container.show();
                
                // Create confetti particles
                confettiContainer.empty();
                const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ff9800', '#28a745'];
                
                for (let i = 0; i < 50; i++) {
                    const confetti = $('<div class="confetti-particle"></div>');
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    const left = Math.random() * 100;
                    const delay = Math.random() * 0.5;
                    const size = 8 + Math.random() * 8;
                    
                    confetti.css({
                        backgroundColor: color,
                        left: left + '%',
                        top: '-20px',
                        width: size + 'px',
                        height: size + 'px',
                        borderRadius: Math.random() > 0.5 ? '50%' : '0',
                        animationDelay: delay + 's',
                        transform: 'rotate(' + (Math.random() * 360) + 'deg)'
                    });
                    
                    confettiContainer.append(confetti);
                }
                
                // Hide celebration after animation completes
                setTimeout(function() {
                    container.fadeOut(500);
                }, 3500);
            }
            
            // Update progress when ken is selected
            $(document).on('change', '#ken_name', function() {
                const regionId = $(this).find(':selected').attr('data-region-id') || '';
                if (regionId) {
                    checkFreeShippingProgress(regionId);
                }
            });
            
            // Also update when cart might change (initial load)
            const initialSubtotal = parseFloat($('#subtotal').text().replace(/[¥,]/g, '')) || 0;
            if (initialSubtotal > 0) {
                // Will be triggered when ken is selected
            }
        });
    </script>
</body>
</html>
