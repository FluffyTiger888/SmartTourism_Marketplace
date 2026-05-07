<!DOCTYPE html>
<html>
<head>
    <title>My Assigned Tours</title>

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

        select {
            padding: 9px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 8px;
            width: 100%;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
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
    <h1>My Assigned Tours</h1>

    <div class="nav-actions">
        <a href="{{ route('home') }}" class="btn">Home</a>
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

@if($assignments->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Assignment ID</th>
                <th>Package</th>
                <th>Customer</th>
                <th>People</th>
                <th>Booking Date</th>
                <th>Current Status</th>
                <th>Update Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($assignments as $assignment)
                <tr>
                    <td>#{{ $assignment->id }}</td>

                    <td>
                        {{ $assignment->booking->tourPackage->title ?? 'Package unavailable' }} <br>
                        <span class="muted">
                            {{ $assignment->booking->tourPackage->destination ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        {{ $assignment->booking->customer->name ?? 'N/A' }} <br>
                        <span class="muted">
                            {{ $assignment->booking->customer->email ?? '' }}
                        </span>
                    </td>

                    <td>
                        {{ $assignment->booking->number_of_people ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $assignment->booking->booking_date ?? 'N/A' }}
                    </td>

                    <td>
                        <span class="status {{ $assignment->status }}">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </td>

                    <td>
                        <form method="POST" action="{{ route('guide.assignments.status', $assignment->id) }}">
                            @csrf

                            <select name="status" required>
                                <option value="upcoming" {{ $assignment->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ongoing" {{ $assignment->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="completed" {{ $assignment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>

                            <button type="submit" class="btn btn-orange">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="card">
        <h2>No assigned tours yet.</h2>
        <p>You have not been assigned to any confirmed customer bookings yet.</p>
    </div>
@endif

</body>
</html>