<!DOCTYPE html>
<html>
<head>
    <title>My Tour Packages</title>

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

        .btn-dark {
            background: #1B4332;
        }

        .btn-orange {
            background: #f97316;
        }

        .btn-blue {
            background: #2563eb;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
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

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        h1 {
            color: #1B4332;
            margin: 0;
        }
    </style>
</head>

<body>

<div class="top">
    <h1>My Tour Packages</h1>

    <div class="nav-actions">
        <a href="{{ route('dashboard') }}" class="btn btn-dark">Dashboard</a>
        <a href="{{ route('agency.performance.index') }}" class="btn btn-blue">Performance</a>
        <a href="{{ route('agency.bookings.index') }}" class="btn btn-orange">Customer Bookings</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>
        <a href="{{ route('agency.packages.create') }}" class="btn">+ Add Package</a>

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

@if($packages->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Destination</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Seats</th>
                <th>Status</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($packages as $package)
                <tr>
                    <td>{{ $package->title }}</td>
                    <td>{{ $package->destination }}</td>
                    <td>৳{{ number_format($package->price, 2) }}</td>
                    <td>{{ $package->duration }} days</td>
                    <td>{{ $package->available_seats }} / {{ $package->max_capacity }}</td>
                    <td>{{ ucfirst($package->status) }}</td>
                    <td>{{ $package->tags }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('agency.packages.edit', $package->id) }}" class="btn">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('agency.packages.destroy', $package->id) }}" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-red">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="card">
        <h2>No packages created yet.</h2>
        <p>Create your first tour package to show it on the public package page.</p>
        <a href="{{ route('agency.packages.create') }}" class="btn">Create Package</a>
    </div>
@endif

</body>
</html>