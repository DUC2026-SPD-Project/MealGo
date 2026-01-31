<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .total-row {
            font-weight: bold;
            font-size: 1.2em;
            color: #1976D2;
            border-top: 2px solid #1976D2;
            padding-top: 15px;
            margin-top: 15px;
        }
        .success-badge {
            background: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Order Confirmed!</h1>
        <p>Thank you for your order, {{ $order->customer_name }}!</p>
        <div class="success-badge">Order #{{ $order->order_number }}</div>
    </div>

    <div class="content">
        <h2>Order Details</h2>
        
        <div class="order-details">
            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Shipping Address:</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
            </p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            @if($order->invoice_number)
                <p><strong>Invoice Number:</strong> {{ $order->invoice_number }}</p>
            @endif
            @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        <h3>Items Ordered</h3>
        <div class="order-details">
            @foreach($items as $item)
                <div class="item-row">
                    <div>
                        <strong>{{ $item->product_name }}</strong><br>
                        <small>Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</small>
                    </div>
                    <div>
                        <strong>${{ number_format($item->quantity * $item->price, 2) }}</strong>
                    </div>
                </div>
            @endforeach
            
            <div class="item-row">
                <div>Subtotal</div>
                <div>${{ number_format($order->subtotal, 2) }}</div>
            </div>
            
            <div class="item-row">
                <div>Tax</div>
                <div>${{ number_format($order->tax, 2) }}</div>
            </div>
            
            <div class="item-row">
                <div>Shipping</div>
                <div>${{ number_format($order->shipping, 2) }}</div>
            </div>
            
            <div class="item-row total-row">
                <div>Total</div>
                <div>${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        <p>📎 <strong>Attachments:</strong> Your order receipt and invoice are attached to this email for your records.</p>
        
        <p>We'll send you another email when your order ships. If you have any questions, please contact us at <a href="mailto:info@smsstore.com">info@smsstore.com</a>.</p>
        
        <p>Thank you for shopping with SMS Store!</p>
    </div>
</body>
</html>