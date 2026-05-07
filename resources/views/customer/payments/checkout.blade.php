<!DOCTYPE html>
<html>
<head>
    <title>Sandbox Payment</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 950px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 28px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1, h2 {
            color: #1B4332;
            margin-top: 0;
        }

        .summary p {
            line-height: 1.7;
        }

        .group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #1B4332;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        .btn {
            background: #2D6A4F;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn-red {
            background: #dc2626;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .sandbox-note {
            background: #D8F3DC;
            color: #1B4332;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .nav {
            max-width: 950px;
            margin: 0 auto 25px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media (max-width: 850px) {
            .container {
                grid-template-columns: 1fr;
            }

            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="nav">
    <h1>Sandbox Payment</h1>

    <div class="nav-actions">
        <a href="{{ route('customer.bookings.index') }}" class="btn">My Bookings</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>
</div>

<div class="container">

    <div class="card summary">
        <h2>Booking Summary</h2>

        <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
        <p><strong>Package:</strong> {{ $booking->tourPackage->title ?? 'Package unavailable' }}</p>
        <p><strong>Destination:</strong> {{ $booking->tourPackage->destination ?? 'N/A' }}</p>
        <p><strong>People:</strong> {{ $booking->number_of_people }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

        <hr>

        <h2>Total: ৳{{ number_format($booking->total_price, 2) }}</h2>

        <div class="sandbox-note">
            This is a sandbox payment page for project demonstration.
            No real money will be charged.
        </div>
    </div>

    <div class="card">
        <h2>Card Payment</h2>

        @if($errors->any())
            <div class="error">
                <strong>Please fix these errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.payments.pay', $booking->id) }}">
            @csrf

            <div class="group">
                <label>Card Holder Name</label>
                <input
                    type="text"
                    name="card_holder"
                    value="{{ old('card_holder', auth()->user()->name) }}"
                    required
                >
            </div>

            <div class="group">
                <label>Card Number</label>
                <input
                    type="text"
                    name="card_number"
                    value="{{ old('card_number', '4242424242424242') }}"
                    placeholder="4242 4242 4242 4242"
                    required
                >
            </div>

            <div class="row">
                <div class="group">
                    <label>Expiry Month</label>
                    <input
                        type="number"
                        name="expiry_month"
                        value="{{ old('expiry_month', '12') }}"
                        min="1"
                        max="12"
                        required
                    >
                </div>

                <div class="group">
                    <label>Expiry Year</label>
                    <input
                        type="number"
                        name="expiry_year"
                        value="{{ old('expiry_year', date('Y') + 1) }}"
                        min="{{ date('Y') }}"
                        required
                    >
                </div>

                <div class="group">
                    <label>CVV</label>
                    <input
                        type="text"
                        name="cvv"
                        value="{{ old('cvv', '123') }}"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn">
                Pay ৳{{ number_format($booking->total_price, 2) }}
            </button>
        </form>
    </div>

</div>

</body>
</html>