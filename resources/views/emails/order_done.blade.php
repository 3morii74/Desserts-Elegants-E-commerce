<!DOCTYPE html>
<html>
<head>
    <title>Order Completed</title>
</head>
<body>
    <p>Hi {{ $order->getOrder()['name'] }}</p>
    <p>Your order has been completed</p>
    <p>Thank you for your purchase!</p>
</body>
</html>
