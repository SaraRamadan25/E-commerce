<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
<h1>Order Confirmation</h1>
<p>Thank you for your order! Here are the order details:</p>

<h2>Order Contents:</h2>
<ul>
    @if(is_array($orderDetails) || is_object($orderDetails))
        @foreach($orderDetails as $item)
            @if(is_array($item) || is_object($item))
                <li>
                    Content: {{ $item['content'] ?? 'N/A' }}<br>
                    Quantity: {{ $item['quantity'] ?? 'N/A' }}
                </li>
            @else
                <li>Item format is incorrect.</li>
            @endif
        @endforeach
    @else
        <li>No order details available.</li>
    @endif
</ul>

<p>Total Quantity: {{ array_sum(array_column($orderDetails, 'quantity', 0)) }}</p>

<p>Feel free to contact us if you have any questions or concerns.</p>

<p>Thank you for shopping with us!</p>
</body>
</html>
