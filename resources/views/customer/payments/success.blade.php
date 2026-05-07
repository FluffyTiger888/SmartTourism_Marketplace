<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 780px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 22px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            color: #166534;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin: 0 auto 20px auto;
        }

        h1 {
            color: #1B4332;
        }

        .details {
            text-align: left;
            background: #f3f7f5;
            padding: 22px;
            border-radius: 16px;
            margin-top: 25px;
        }

        .details p {
            line-height: 1.7;
        }

        .btn {
            background: #2D6A4F;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 22px;
            margin-right: 8px;
        }

        .btn-red {
            background: #dc2626;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="icon">✓</div>

    <h1>Payment Successful</h1>

    <p>Your booking has been confirmed successfully.</p>

    <div class="details">
        <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
        <p><strong>Package:</strong> {{ $booking->tourPackage->title ?? 'Package unavailable' }}</p>
        <p><strong>Destination:</strong> {{ $booking->tourPackage->destination ?? 'N/A' }}</p>
        <p><strong>Number of People:</strong> {{ $booking->number_of_people }}</p>
        <p><strong>Total Paid:</strong> ৳{{ number_format($booking->total_price, 2) }}</p>
        <p><strong>Booking Status:</strong> {{ ucfirst($booking->status) }}</p>

        @if($booking->payment)
            <p><strong>Transaction ID:</strong> {{ $booking->payment->transaction_id }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($booking->payment->payment_status) }}</p>
        @endif
    </div>

    <a href="{{ route('customer.bookings.index') }}" class="btn">
        View My Bookings
    </a>

    <a href="{{ route('packages.index') }}" class="btn">
        Browse More Packages
    </a>

    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-red">Logout</button>
    </form>
</div>

</body>
</html>