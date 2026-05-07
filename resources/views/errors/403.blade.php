<!DOCTYPE html>
<html>
<head>
    <title>Access Denied</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .card {
            background: white;
            max-width: 620px;
            width: 100%;
            text-align: center;
            padding: 45px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.10);
        }

        .code {
            font-size: 80px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }

        h1 {
            color: #1B4332;
            margin-bottom: 12px;
        }

        p {
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .btn {
            background: #2D6A4F;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-red {
            background: #dc2626;
        }

        .btn-gray {
            background: #6b7280;
        }
    </style>
</head>

<body>

<div class="card">
    <div class="code">403</div>

    <h1>Access Denied</h1>

    <p>
        You do not have permission to access this page.
        This area is protected by role-based access control in the TravelMarket system.
    </p>

    @auth
        <a href="{{ route('dashboard') }}" class="btn">
            Go to My Dashboard
        </a>

        <a href="{{ route('home') }}" class="btn btn-gray">
            Home
        </a>

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-red">
                Logout
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn">
            Login
        </a>

        <a href="{{ route('home') }}" class="btn btn-gray">
            Home
        </a>
    @endauth
</div>

</body>
</html>