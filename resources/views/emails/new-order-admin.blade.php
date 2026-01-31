<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received - {{ $order->order_number }}</title>
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
            background: linear-gradient(135deg, #FF9800, #F57C00);
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
            color: #FF9800;
            border-top: 2px solid #FF9800;
            padding-top: 15px;
            margin-top: 15px;
        }
        .alert-badge {
            background: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
        }
        .action-button {
            background: #1976D2;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 New Order Alert!</h1>
        <p>Hello {{ $admin_name }}, you have a new order!</p>
        <div class="alert-badge">Order #{{ $order->order_number }}</div>
    </div>

    <div class="content">
        <h2>Order Summary</h2>
        
        <div class="order-details">
            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Shipping Address:</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->city }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}
            </p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
            @if($order->notes)
                <p><strong>Customer Notes:</strong> {{ $order->notes }}</p>
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
                <div>Total Revenue</div>
                <div>${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/dashboard') }}" class="action-button">
                View Dashboard
            </a>
        </div>

        <p><strong>Action Required:</strong> Please process this order and prepare it for shipping.</p>
        
        <p>This is an automated notification from SMS Store.</p>
    </div>
</body>
</html>