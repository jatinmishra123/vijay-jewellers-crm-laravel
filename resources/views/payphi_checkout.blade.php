<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>PayPhi Checkout</title>
</head>

<body>
    <h2>PayPhi Sandbox Checkout</h2>

    @if(session('error'))
    <p style="color:red">{{ session('error') }}</p> @endif

    <form method="post" action="{{ route('payphi.initiate') }}">
        @csrf
        <label>Amount (INR)</label><br>
        <input type="number" name="amount" value="100" min="1" step="1" required><br><br>

        <label>Name</label><br>
        <input type="text" name="customer_name" value="Test User"><br><br>

        <label>Email</label><br>
        <input type="email" name="customer_email" value="test@example.com"><br><br>

        <label>Mobile</label><br>
        <input type="text" name="customer_mobile" value="9999999999"><br><br>

        <button type="submit">Pay via Phicommerce</button>
    </form>
</body>

</html>