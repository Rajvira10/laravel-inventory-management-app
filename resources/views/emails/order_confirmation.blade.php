<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">Order Confirmation</h1>
                <p>Dear {{ $order->customer_name }},</p>
                <p>Your order (Invoice No: {{ $order->invoice_no }}) has been confirmed.</p>
                <p>Total amount: ${{ $order->amount }}</p>
                <p>Payment method: {{ $order->payment_method }}</p>
                <p>Thank you for shopping with us!</p>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
