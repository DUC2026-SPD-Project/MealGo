<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .receipt-header {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .receipt-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.05);
        }
        
        .company-logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .company-info {
            position: relative;
            z-index: 1;
            opacity: 0.9;
        }
        
        .receipt-title {
            background: #f8f9fa;
            padding: 20px 30px;
            border-bottom: 3px solid #1976D2;
        }
        
        .receipt-title h1 {
            color: #1976D2;
            font-size: 2rem;
            margin-bottom: 5px;
        }
        
        .order-number {
            color: #666;
            font-size: 1.1rem;
        }
        
        .receipt-content {
            padding: 30px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #1976D2;
        }
        
        .info-section h3 {
            color: #1976D2;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .info-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .items-section {
            margin-bottom: 30px;
        }
        
        .items-title {
            color: #1976D2;
            font-size: 1.4rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .items-table th {
            background: #1976D2;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .item-name {
            font-weight: 600;
            color: #333;
        }
        
        .item-price {
            text-align: right;
            font-weight: 600;
            color: #1976D2;
        }
        
        .totals-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .total-row:last-child {
            border-bottom: none;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #1976D2;
        }
        
        .total-label {
            font-weight: 600;
            color: #555;
        }
        
        .total-value {
            font-weight: 600;
            color: #333;
        }
        
        .grand-total .total-label,
        .grand-total .total-value {
            font-size: 1.3rem;
            color: #1976D2;
        }
        
        .receipt-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .thank-you {
            font-size: 1.3rem;
            color: #1976D2;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .footer-note {
            color: #666;
            margin-bottom: 20px;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .date-time {
            color: #666;
            font-size: 0.95rem;
            margin-top: 10px;
        }
        
        @media print {
            body {
                background: white;
            }
            
            .receipt-container {
                box-shadow: none;
                margin: 0;
            }
        }
        
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
            
            .items-table {
                font-size: 0.9rem;
            }
            
            .items-table th,
            .items-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            <div class="company-logo">🛍️ {{ $company['name'] }}</div>
            <div class="company-info">
                <div>{{ $company['address'] }}</div>
                <div>📞 {{ $company['phone'] }} | 📧 {{ $company['email'] }}</div>
            </div>
        </div>

        <!-- Title -->
        <div class="receipt-title">
            <h1>🧾 Order Receipt</h1>
            <div class="order-number">Order #{{ $order->order_number }}</div>
            <div class="date-time">{{ $order->created_at ? $order->created_at->format('F d, Y \a\t g:i A') : now()->format('F d, Y \a\t g:i A') }}</div>
        </div>

        <!-- Content -->
        <div class="receipt-content">
            <!-- Customer & Order Info -->
            <div class="info-grid">
                <div class="info-section">
                    <h3>👤 Customer Information</h3>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $order->customer_email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $order->customer_phone }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3>📦 Order Details</h3>
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="status-badge">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment:</span>
                        <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value">{{ $order->created_at ? $order->created_at->format('M d, Y') : now()->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="info-section" style="margin-bottom: 30px;">
                <h3>🚚 Shipping Address</h3>
                <div class="info-value">
                    {{ $order->shipping_address }}<br>
                    {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                </div>
                @if($order->notes)
                    <div style="margin-top: 15px;">
                        <span class="info-label">Notes:</span>
                        <div class="info-value" style="margin-top: 5px; font-style: italic;">{{ $order->notes }}</div>
                    </div>
                @endif
            </div>

            <!-- Items -->
            <div class="items-section">
                <h2 class="items-title">🛒 Order Items</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: center;">Quantity</th>
                            <th style="text-align: right;">Unit Price</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td class="item-name">{{ $item->product_name }}</td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td class="item-price">${{ number_format($item->price, 2) }}</td>
                                <td class="item-price">${{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="totals-section">
                <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span class="total-value">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                <div class="total-row">
                    <span class="total-label">Tax (10%):</span>
                    <span class="total-value">${{ number_format($order->tax, 2) }}</span>
                </div>
                
                <div class="total-row">
                    <span class="total-label">Shipping:</span>
                    <span class="total-value">${{ number_format($order->shipping, 2) }}</span>
                </div>
                
                <div class="total-row grand-total">
                    <span class="total-label">💰 Grand Total:</span>
                    <span class="total-value">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <div class="thank-you">🙏 Thank You for Your Order!</div>
            <div class="footer-note">
                We appreciate your business and hope you enjoy your purchase.
                <br>If you have any questions, please don't hesitate to contact us.
            </div>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span>📞</span>
                    <span>{{ $company['phone'] }}</span>
                </div>
                <div class="contact-item">
                    <span>📧</span>
                    <span>{{ $company['email'] }}</span>
                </div>
                <div class="contact-item">
                    <span>🌐</span>
                    <span>www.smsstore.com</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>