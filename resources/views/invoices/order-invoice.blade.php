<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 30px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        
        .logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 10px;
            color: #666;
            line-height: 1.6;
        }
        
        .contact-info {
            font-size: 10px;
            color: #10b981;
            line-height: 1.6;
        }
        
        .bill-to-section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #333;
        }
        
        .bill-to-content {
            font-size: 10px;
            line-height: 1.6;
            color: #666;
        }
        
        .invoice-meta {
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        .invoice-meta table {
            width: auto;
            float: right;
        }
        
        .invoice-meta td {
            padding: 3px 10px;
        }
        
        .invoice-meta .label {
            font-weight: bold;
            color: #666;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            clear: both;
        }
        
        .items-table thead {
            background-color: #10b981;
            color: white;
        }
        
        .items-table th {
            padding: 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .items-table th.center {
            text-align: center;
        }
        
        .items-table th.right {
            text-align: right;
        }
        
        .items-table tbody tr {
            background-color: #e0f2f1;
        }
        
        .items-table tbody tr:nth-child(even) {
            background-color: #f0fdf4;
        }
        
        .items-table td {
            padding: 10px;
            font-size: 10px;
            color: #333;
        }
        
        .items-table td.center {
            text-align: center;
        }
        
        .items-table td.right {
            text-align: right;
        }
        
        .product-image {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
        }
        
        .totals-section {
            width: 100%;
            margin-top: 20px;
        }
        
        .totals-table {
            float: right;
            width: 300px;
        }
        
        .totals-table tr td {
            padding: 5px 10px;
            font-size: 11px;
        }
        
        .totals-table tr td:first-child {
            text-align: right;
            color: #666;
        }
        
        .totals-table tr td:last-child {
            text-align: right;
            font-weight: 600;
            color: #333;
        }
        
        .totals-table .total-row {
            background-color: #10b981;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        
        .totals-table .total-row td {
            padding: 12px 10px;
            color: white;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border-top: 1px solid #e5e5e5;
            padding-top: 15px;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                @php
                    $logoPath = public_path('images/logo-header.png');
                    $logoData = '';
                    if (file_exists($logoPath)) {
                        try {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mimeType = finfo_file($finfo, $logoPath);
                            finfo_close($finfo);
                            
                            $logoContent = file_get_contents($logoPath);
                            if ($logoContent) {
                                $base64Logo = base64_encode($logoContent);
                                $logoData = 'data:' . $mimeType . ';base64,' . $base64Logo;
                            }
                        } catch (\Exception $e) {
                            // Skip logo if error
                        }
                    }
                @endphp
                @if($logoData)
                    <img src="{{ $logoData }}" alt="Helairisi Logo" class="logo">
                @endif
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="contact-info">
                    +8180 4455 0579<br>
                    helarisiproducts@gmail.com<br>
                    Ibaraki ken, Moriya Shi
                </div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="bill-to-section">
            <div class="section-title">Bill To:</div>
            <div class="bill-to-content">
                <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                {{ $order->apartment }}<br>
                {{ $order->ken_name }}, {{ $order->region->region_name }}<br>
                Postal Code: {{ $order->postal_code }}<br>
                Mobile: {{ $order->mobile_number }}<br>
                Email: {{ $order->email }}
            </div>
        </div>

        <!-- Invoice Meta -->
        <div class="invoice-meta">
            <table>
                <tr>
                    <td class="label">Invoice no.:</td>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="label">Date:</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
                <!-- <tr>
                    <td class="label">Status:</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr> -->
                <!-- @if($order->delivery_date)
                <tr>
                    <td class="label">Delivery Date:</td>
                    <td>{{ $order->delivery_date->format('D, M d, Y') }}</td>
                </tr>
                @endif -->
                <!-- @if($order->delivery_time_slot)
                <tr>
                    <td class="label">Time Slot:</td>
                    <td>
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
                        {{ $timeSlots[$order->delivery_time_slot] ?? $order->delivery_time_slot }}
                    </td>
                </tr>
                @endif -->
            </table>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>IMAGE</th>
                    <th>ITEM</th>
                    <th class="center">QTY</th>
                    <th class="right">PRICE</th>
                    <th class="right">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="center">
                        @php
                            $imageData = '';
                            
                            // Try to load actual product image
                            if ($item->product && $item->product->image) {
                                // Database stores 'products/filename.jpg', so use it directly
                                $imagePath = public_path($item->product->image);
                                
                                if (file_exists($imagePath)) {
                                    try {
                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                        $mimeType = finfo_file($finfo, $imagePath);
                                        finfo_close($finfo);
                                        
                                        $imageContent = file_get_contents($imagePath);
                                        
                                        if ($imageContent) {
                                            $base64 = base64_encode($imageContent);
                                            $imageData = 'data:' . $mimeType . ';base64,' . $base64;
                                        }
                                    } catch (\Exception $e) {
                                        // Use placeholder if error
                                    }
                                }
                            }
                            
                            // Use placeholder if no image found
                            if (!$imageData) {
                                // Simple SVG placeholder image
                                $placeholderSvg = '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="50" fill="#e5e7eb"/><text x="25" y="30" font-family="Arial" font-size="10" fill="#9ca3af" text-anchor="middle">No Image</text></svg>';
                                $imageData = 'data:image/svg+xml;base64,' . base64_encode($placeholderSvg);
                            }
                        @endphp
                        <img src="{{ $imageData }}" 
                             alt="{{ $item->product->product_name }}" 
                             class="product-image">
                    </td>
                    <td>
                        {{ $item->product->product_name }}
                        @if($item->product->is_frozen)
                            <span style="background-color: #dbeafe; color: #1e40af; font-size: 8px; padding: 2px 6px; border-radius: 3px; margin-left: 5px; font-weight: 600;">FROZEN</span>
                        @endif
                    </td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">¥{{ number_format($item->price, 0) }}</td>
                    <td class="right">¥{{ number_format($item->subtotal, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Sub Total:</td>
                    <td>¥{{ number_format($order->subtotal, 0) }}</td>
                </tr>
                <tr>
                    <td>Tax (8%):</td>
                    <td>¥{{ number_format($order->tax_amount, 0) }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td>¥{{ number_format($order->delivery_charge, 0) }}</td>
                </tr>
                @if($order->frozen_charge > 0)
                <tr>
                    <td>Frozen Item Charge:</td>
                    <td>¥{{ number_format($order->frozen_charge, 0) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>AMOUNT DUE:</td>
                    <td>¥{{ number_format($order->total_amount, 0) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            THANK YOU
        </div>
    </div>
</body>
</html>
