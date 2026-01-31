<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice - {{ $order->invoice_number ?: $order->order_number }}</title>
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
        
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
            color: white;
            padding: 40px 30px;
            position: relative;
        }
        
        .invoice-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.05);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .company-details {
            opacity: 0.9;
            line-height: 1.4;
        }
        
        .invoice-info {
            text-align: right;
            flex: 1;
        }
        
        .invoice-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .invoice-date {
            opacity: 0.9;
        }
        
        .invoice-status {
            background: #fff;
            color: #2E7D32;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            margin-top: 10px;
            display: inline-block;
        }
        
        .invoice-status.paid {
            background: #4CAF50;
            color: white;
        }
        
        .invoice-status.pending {
            background: #FF9800;
            color: white;
        }
        
        .invoice-status.overdue {
            background: #F44336;
            color: white;
        }
        
        .invoice-content {
            padding: 30px;
        }
        
        .billing-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .billing-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        
        .billing-section h3 {
            color: #2E7D32;
            margin-bottom: 15px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .billing-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .billing-label {
            font-weight: 600;
            color: #555;
        }
        
        .billing-value {
            color: #333;
        }
        
        .items-section {
            margin-bottom: 30px;
        }
        
        .items-title {
            color: #2E7D32;
            font-size: 1.4rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
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
            background: #2E7D32;
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
            color: #2E7D32;
        }
        
        .totals-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            margin-bottom: 30px;
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
            border-top: 2px solid #2E7D32;
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
            color: #2E7D32;
        }
        
        .payment-info {
            background: #e8f5e8;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
            margin-bottom: 30px;
        }
        
        .payment-info h3 {
            color: #2E7D32;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .payment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .terms-section {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            margin-bottom: 30px;
        }
        
        .terms-section h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        
        .terms-section p {
            color: #856404;
            margin-bottom: 8px;
        }
        
        .invoice-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .thank-you {
            font-size: 1.3rem;
            color: #2E7D32;
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
        
        @media print {
            body {
                background: white;
            }
            
            .invoice-container {
                box-shadow: none;
                margin: 0;
            }
        }
        
        @media (max-width: 600px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .invoice-info {
                text-align: left;
            }
            
            .billing-info {
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
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="header-content">
                <div class="company-info">
                    <div class="company-logo">🏪 {{ $company['name'] }}</div>
                    <div class="company-details">
                        <div>{{ $company['address'] }}</div>
                        <div>📞 {{ $company['phone'] }}</div>
                        <div>📧 {{ $company['email'] }}</div>
                        <div>🌐 www.smsstore.com</div>
                    </div>
                </div>
                
                <div class="invoice-info">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number"># {{ $order->invoice_number ?: $order->order_number }}</div>
                    <div class="invoice-date">
                        Date: {{ $order->invoice_date ? $order->invoice_date->format('M d, Y') : $order->created_at->format('M d, Y') }}
                    </div>
                    @if($order->due_date)
                        <div class="invoice-date">
                            Due: {{ $order->due_date->format('M d, Y') }}
                        </div>
                    @endif
                    <div class="invoice-status {{ strtolower($order->invoice_status) }}">
                        {{ $order->invoice_status }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="invoice-content">
            <!-- Billing Information -->
            <div class="billing-info">
                <div class="billing-section">
                    <h3>📋 Bill To</h3>
                    <div class="billing-item">
                        <span class="billing-label">Name:</span>
                        <span class="billing-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Email:</span>
                        <span class="billing-value">{{ $order->customer_email }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Phone:</span>
                        <span class="billing-value">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Address:</span>
                        <span class="billing-value">
                            {{ $order->shipping_address }}<br>
                            {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
                        </span>
                    </div>
                </div>

                <div class="billing-section">
                    <h3>📄 Invoice Details</h3>
                    <div class="billing-item">
                        <span class="billing-label">Invoice #:</span>
                        <span class="billing-value">{{ $order->invoice_number ?: $order->order_number }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Order #:</span>
                        <span class="billing-value">{{ $order->order_number }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Status:</span>
                        <span class="billing-value">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="billing-item">
                        <span class="billing-label">Payment:</span>
                        <span class="billing-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="items-section">
                <h2 class="items-title">🛒 Invoice Items</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Unit Price</th>
                            <th style="text-align: right;">Amount</th>
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
                    <span class="total-label">💰 Total Amount:</span>
                    <span class="total-value">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="payment-info">
                <h3>💳 Payment Information</h3>
                <div class="payment-details">
                    <div class="payment-item">
                        <span class="billing-label">Payment Method:</span>
                        <span class="billing-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="payment-item">
                        <span class="billing-label">Payment Status:</span>
                        <span class="billing-value">{{ $order->status === 'completed' ? 'Paid' : 'Pending' }}</span>
                    </div>
                    @if($order->due_date)
                        <div class="payment-item">
                            <span class="billing-label">Due Date:</span>
                            <span class="billing-value">{{ $order->due_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="terms-section">
                <h3>📋 Terms & Conditions</h3>
                <p>• Payment is due within 30 days of invoice date</p>
                <p>• Late payments may incur additional charges</p>
                <p>• All sales are final unless otherwise specified</p>
                <p>• Please retain this invoice for your records</p>
                @if($order->notes)
                    <p><strong>Special Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="thank-you">🙏 Thank You for Your Business!</div>
            <div class="footer-note">
                We appreciate your trust in our services. If you have any questions about this invoice,
                <br>please don't hesitate to contact us using the information below.
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