<!DOCTYPE html>
<html>
<head>
    <title>Agency Performance Monitoring</title>

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
            flex-wrap: wrap;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
            border-left: 6px solid #2D6A4F;
        }

        .stat-card h3 {
            margin: 0;
            color: #6b7280;
            font-size: 15px;
        }

        .stat-card h2 {
            margin: 12px 0 0 0;
            color: #1B4332;
            font-size: 30px;
        }

        .orange {
            border-left-color: #f97316;
        }

        .blue {
            border-left-color: #2563eb;
        }

        .red {
            border-left-color: #dc2626;
        }

        .purple {
            border-left-color: #7c3aed;
        }

        .section {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
            margin-bottom: 30px;
        }

        .performance-badge {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
        }

        .excellent {
            background: #dcfce7;
            color: #166534;
        }

        .good {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .average {
            background: #fef3c7;
            color: #92400e;
        }

        .poor {
            background: #fee2e2;
            color: #991b1b;
        }

        .neutral {
            background: #e5e7eb;
            color: #374151;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 18px;
            overflow: hidden;
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

        .review-card {
            background: #f8fafc;
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 15px;
            border-left: 5px solid #2D6A4F;
        }

        .stars {
            color: #f59e0b;
            font-weight: bold;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }

        .empty-box {
            background: #f8fafc;
            padding: 22px;
            border-radius: 14px;
            color: #6b7280;
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
    <h1>Agency Performance Monitoring</h1>

    <div class="nav-actions">
        <a href="{{ route('agency.packages.index') }}" class="btn">My Packages</a>
        <a href="{{ route('agency.bookings.index') }}" class="btn btn-orange">Customer Bookings</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>
</div>

<div class="section">
    <h2>Overall Performance Status</h2>

    <p>
        This status is calculated from customer ratings, reviews, confirmed bookings, revenue,
        and completed assigned tours.
    </p>

    <span class="performance-badge {{ $performanceClass }}">
        {{ $performanceStatus }}
    </span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Packages</h3>
        <h2>{{ $totalPackages }}</h2>
    </div>

    <div class="stat-card blue">
        <h3>Total Bookings</h3>
        <h2>{{ $totalBookings }}</h2>
    </div>

    <div class="stat-card">
        <h3>Confirmed Bookings</h3>
        <h2>{{ $confirmedBookings }}</h2>
    </div>

    <div class="stat-card orange">
        <h3>Pending Bookings</h3>
        <h2>{{ $pendingBookings }}</h2>
    </div>

    <div class="stat-card red">
        <h3>Cancelled Bookings</h3>
        <h2>{{ $cancelledBookings }}</h2>
    </div>

    <div class="stat-card">
        <h3>Total Revenue</h3>
        <h2>৳{{ number_format($totalRevenue, 2) }}</h2>
    </div>

    <div class="stat-card purple">
        <h3>Average Rating</h3>
        <h2>
            @if($averageRating)
                {{ number_format($averageRating, 1) }}/5
            @else
                N/A
            @endif
        </h2>
    </div>

    <div class="stat-card blue">
        <h3>Total Reviews</h3>
        <h2>{{ $totalReviews }}</h2>
    </div>

    <div class="stat-card">
        <h3>Completed Tours</h3>
        <h2>{{ $completedTours }}</h2>
    </div>
</div>

<div class="section">
    <h2>Top Packages by Bookings</h2>

    @if($topPackages->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Destination</th>
                    <th>Total Bookings</th>
                    <th>Average Rating</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($topPackages as $package)
                    <tr>
                        <td>{{ $package->title }}</td>
                        <td>{{ $package->destination }}</td>
                        <td>{{ $package->bookings_count }}</td>
                        <td>
                            @if($package->reviews_avg_rating)
                                {{ number_format($package->reviews_avg_rating, 1) }}/5
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ ucfirst($package->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-box">
            No packages found for this agency.
        </div>
    @endif
</div>

<div class="section">
    <h2>Recent Customer Feedback</h2>

    @if($recentReviews->count() > 0)
        @foreach($recentReviews as $review)
            <div class="review-card">
                <p class="stars">
                    Rating: {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                </p>

                <p>
                    {{ $review->comment ?? 'No comment provided.' }}
                </p>

                <p class="muted">
                    Package: {{ $review->tourPackage->title ?? 'Package unavailable' }}
                    |
                    Customer: {{ $review->customer->name ?? 'Customer' }}
                </p>
            </div>
        @endforeach
    @else
        <div class="empty-box">
            No customer reviews yet. Reviews will appear here after customers complete bookings and submit feedback.
        </div>
    @endif
</div>

</body>
</html>