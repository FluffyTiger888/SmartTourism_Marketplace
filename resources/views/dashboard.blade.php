<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
        }

        .navbar {
            background: #1B4332;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
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

        .logout-btn {
            background: #dc2626;
        }

        .container {
            padding: 40px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: auto;
        }

        h1 {
            color: #1B4332;
        }

        p {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>TravelMarket Dashboard</h2>

    <div class="nav-actions">
        <a href="{{ route('home') }}" class="btn">Home</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>

        @if(auth()->user()->role === 'agency_owner')
            <a href="{{ route('agency.packages.index') }}" class="btn">Manage Packages</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn logout-btn">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="card">
        <h1>Welcome, {{ auth()->user()->name }}</h1>

        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Role:</strong> {{ auth()->user()->role }}</p>

        <p>
            You are successfully logged in. Use the navigation buttons above to browse packages,
            manage packages, or logout from the system.
        </p>
    </div>
</div>

</body>
</html>