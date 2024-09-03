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
    @foreach($orderDetails as $item)
        <li><strong>{{ $item['content'] }}:</strong> {{ $item['quantity'] }}</li>
    @endforeach
</ul>

<p><strong>Total Quantity:</strong> {{ $totalQuantity }}</p>
<p><strong>Total Amount:</strong> ${{ $totalAmount }}</p>

<p>Feel free to contact us if you have any questions or concerns.</p>

<p>Thank you for shopping with us!</p>
</body>
</html>
