<!DOCTYPE html>
<html>
<head>
    <title>Admin Financial Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .btn-blue {
            background: #2563eb;
        }

        .btn-gray {
            background: #6b7280;
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

        .stat-card.orange {
            border-left-color: #f97316;
        }

        .stat-card.blue {
            border-left-color: #2563eb;
        }

        .stat-card.red {
            border-left-color: #dc2626;
        }

        .section {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
            margin-bottom: 30px;
        }

        .chart-box {
            height: 340px;
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

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .successful {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .failed {
            background: #fee2e2;
            color: #991b1b;
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
    <h1>Admin Financial Dashboard</h1>

    <div class="nav-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-blue">Manage Users</a>
        <a href="{{ route('home') }}" class="btn btn-gray">Home</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Revenue</h3>
        <h2>৳{{ number_format($totalRevenue, 2) }}</h2>
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

    <div class="stat-card blue">
        <h3>Total Customers</h3>
        <h2>{{ $totalCustomers }}</h2>
    </div>

    <div class="stat-card">
        <h3>Total Agencies</h3>
        <h2>{{ $totalAgencies }}</h2>
    </div>

    <div class="stat-card orange">
        <h3>Total Tour Guides</h3>
        <h2>{{ $totalGuides }}</h2>
    </div>

    <div class="stat-card">
        <h3>Total Packages</h3>
        <h2>{{ $totalPackages }}</h2>
    </div>
</div>

<div class="section">
    <h2>Monthly Revenue Chart</h2>

    @if(count($chartLabels) > 0)
        <div class="chart-box">
            <canvas id="revenueChart"></canvas>
        </div>
    @else
        <div class="empty-box">
            No payment data available yet. Once customers make sandbox payments, revenue data will appear here.
        </div>
    @endif
</div>

<div class="section">
    <h2>Recent Payment Transactions</h2>

    @if($recentPayments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($recentPayments as $payment)
                    <tr>
                        <td>{{ $payment->transaction_id }}</td>

                        <td>
                            {{ $payment->booking->customer->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $payment->booking->tourPackage->title ?? 'Package unavailable' }}
                        </td>

                        <td>
                            ৳{{ number_format($payment->amount, 2) }}
                        </td>

                        <td>
                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                        </td>

                        <td>
                            <span class="status {{ $payment->payment_status }}">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </td>

                        <td>
                            {{ $payment->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-box">
            No payment transactions found yet.
        </div>
    @endif
</div>

@if(count($chartLabels) > 0)
<script>
    const revenueLabels = @json($chartLabels);
    const revenueData = @json($chartData);

    const ctx = document.getElementById('revenueChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                backgroundColor: '#2D6A4F',
                borderColor: '#1B4332',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endif

</body>
</html>