<!DOCTYPE html>
<html>
<head>
    <title>Agency Bookings</title>

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

        .upcoming {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .ongoing {
            background: #fef3c7;
            color: #92400e;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        select {
            padding: 9px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 8px;
            width: 100%;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="top">
    <h1>Agency Bookings</h1>

    <div class="nav-actions">
        <a href="{{ route('agency.packages.index') }}" class="btn">My Packages</a>
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
                <th>Customer</th>
                <th>Package</th>
                <th>People</th>
                <th>Total Price</th>
                <th>Booking Status</th>
                <th>Current Guide</th>
                <th>Assign Guide</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>

                    <td>
                        {{ $booking->customer->name ?? 'N/A' }} <br>
                        <span class="muted">{{ $booking->customer->email ?? '' }}</span>
                    </td>

                    <td>
                        {{ $booking->tourPackage->title ?? 'Package deleted' }} <br>
                        <span class="muted">{{ $booking->tourPackage->destination ?? '' }}</span>
                    </td>

                    <td>{{ $booking->number_of_people }}</td>

                    <td>৳{{ number_format($booking->total_price, 2) }}</td>

                    <td>
                        <span class="status {{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    <td>
                        @if($booking->guideAssignment)
                            {{ $booking->guideAssignment->guide->name ?? 'Guide unavailable' }} <br>
                            <span class="status {{ $booking->guideAssignment->status }}">
                                {{ ucfirst($booking->guideAssignment->status) }}
                            </span>
                        @else
                            <span class="muted">Not assigned</span>
                        @endif
                    </td>

                    <td>
                        @if($booking->status === 'confirmed')
                            <form method="POST" action="{{ route('agency.bookings.assignGuide', $booking->id) }}">
                                @csrf

                                <select name="tour_guide_id" required>
                                    <option value="">Select Guide</option>

                                    @foreach($guides as $guide)
                                        <option value="{{ $guide->id }}">
                                            {{ $guide->name }} - {{ $guide->email }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-orange">
                                    Assign
                                </button>
                            </form>
                        @else
                            <span class="muted">Only confirmed bookings can be assigned.</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="card">
        <h2>No bookings found.</h2>
        <p>No customer has booked your packages yet.</p>
    </div>
@endif

</body>
</html>