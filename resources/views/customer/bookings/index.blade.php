<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        h1 {
            color: #1B4332;
            margin: 0;
        }

        h2 {
            color: #1B4332;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            background: #2D6A4F;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-block;
        }

        .btn-red {
            background: #dc2626;
        }

        .btn-orange {
            background: #f97316;
        }

        .btn-dark {
            background: #1B4332;
        }

        .btn-blue {
            background: #2563eb;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error ul {
            margin: 0;
            padding-left: 20px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #1B4332;
            color: white;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            .top {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .nav-actions {
                flex-wrap: wrap;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>

<div class="top">
    <h1>My Bookings</h1>

    <div class="nav-actions">
        <a href="{{ route('home') }}" class="btn btn-dark">Home</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($bookings->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Package</th>
                <th>Destination</th>
                <th>People</th>
                <th>Total Price</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>

                    <td>
                        {{ $booking->tourPackage->title ?? 'Package deleted' }}
                    </td>

                    <td>
                        {{ $booking->tourPackage->destination ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $booking->number_of_people }}
                    </td>

                    <td>
                        ৳{{ number_format($booking->total_price, 2) }}
                    </td>

                    <td>
                        {{ $booking->booking_date }}
                    </td>

                    <td>
                        <span class="status {{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    <td>
                        @if($booking->payment)
                            <span class="status confirmed">
                                {{ ucfirst($booking->payment->payment_status) }}
                            </span>

                            <br>

                            <span class="muted">
                                {{ $booking->payment->transaction_id }}
                            </span>
                        @else
                            <span class="status pending">
                                Unpaid
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="actions">
                            @if($booking->status === 'pending')
                                <a href="{{ route('customer.payments.checkout', $booking->id) }}" class="btn btn-orange">
                                    Pay Now
                                </a>

                                <form method="POST" action="{{ route('customer.bookings.cancel', $booking->id) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf

                                    <button type="submit" class="btn btn-red">
                                        Cancel
                                    </button>
                                </form>
                            @elseif($booking->status === 'confirmed')
                                <a href="{{ route('packages.show', $booking->tour_package_id) }}" class="btn">
                                    View Package
                                </a>

                                <a href="{{ route('customer.reviews.create', $booking->tour_package_id) }}" class="btn btn-blue">
                                    Review
                                </a>
                            @else
                                <span class="muted">No action available</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="card">
        <h2>No bookings yet.</h2>

        <p>
            You have not booked any tour packages yet. Browse available packages and make your first booking.
        </p>

        <a href="{{ route('packages.index') }}" class="btn">
            Browse Packages
        </a>
    </div>
@endif

</body>
</html>