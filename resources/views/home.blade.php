<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Tourism & Travel Marketplace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f9fb;
            color: #1f2937;
        }

        .navbar {
            background: white;
            padding: 18px 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: #0f766e;
        }

        .logo span {
            color: #f97316;
        }

        .nav-links a {
            text-decoration: none;
            margin-left: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        .nav-links .register-btn {
            background: #0f766e;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
        }

        .hero {
            padding: 80px 70px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 45px;
            align-items: center;
        }

        .hero h1 {
            font-size: 52px;
            line-height: 1.1;
            color: #064e3b;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 30px;
        }

        .hero-buttons a {
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 8px;
            font-weight: bold;
            margin-right: 12px;
            display: inline-block;
        }

        .primary-btn {
            background: #0f766e;
            color: white;
        }

        .secondary-btn {
            background: white;
            color: #0f766e;
            border: 2px solid #0f766e;
        }

        .feature-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .feature-box h2 {
            color: #0f766e;
            margin-top: 0;
        }

        .feature-item {
            background: #ecfdf5;
            padding: 14px 16px;
            margin-bottom: 12px;
            border-radius: 10px;
            border-left: 5px solid #0f766e;
        }

        .section {
            padding: 60px 70px;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            color: #064e3b;
            margin-bottom: 35px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .card {
            background: white;
            padding: 26px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }

        .card h3 {
            color: #0f766e;
            margin-bottom: 10px;
        }

        .card p {
            color: #4b5563;
            line-height: 1.5;
        }

        .stats {
            background: #064e3b;
            color: white;
            padding: 50px 70px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            text-align: center;
        }

        .stat h2 {
            font-size: 34px;
            margin: 0;
            color: #facc15;
        }

        .stat p {
            margin-top: 8px;
        }

        .footer {
            background: #022c22;
            color: white;
            text-align: center;
            padding: 22px;
        }

        @media (max-width: 900px) {
            .navbar {
                padding: 18px 25px;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 50px 25px;
            }

            .hero h1 {
                font-size: 38px;
            }

            .section {
                padding: 45px 25px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
                padding: 40px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">Travel<span>Market</span></div>

        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="register-btn">Register</a>
            @endauth
        </div>
    </div>

    <section class="hero">
        <div>
            <h1>Book Tours Easily With Smart Tourism Marketplace</h1>

            <p>
                A complete tourism and travel marketplace where customers can browse tour packages,
                book trips, make payments, and submit reviews. Travel agencies can manage packages,
                tour guides can view assigned tours, and admins can monitor the whole system.
            </p>

            <div class="hero-buttons">
                <a href="{{ route('packages.index') }}" class="primary-btn">Browse Packages</a>

                @guest
                    <a href="{{ route('register') }}" class="secondary-btn">Create Account</a>
                @else
                    <a href="{{ route('dashboard') }}" class="secondary-btn">Go Dashboard</a>
                @endguest
            </div>
        </div>

        <div class="feature-box">
            <h2>Main System Features</h2>

            <div class="feature-item">Role-based login and dashboards</div>
            <div class="feature-item">Tour package creation and management</div>
            <div class="feature-item">Customer booking and seat availability</div>
            <div class="feature-item">Sandbox payment system</div>
            <div class="feature-item">Review and rating system</div>
            <div class="feature-item">Admin analytics and revenue tracking</div>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">User Roles</h2>

        <div class="cards">
            <div class="card">
                <h3>Customer</h3>
                <p>Customers can search packages, book tours, pay online, and give reviews.</p>
            </div>

            <div class="card">
                <h3>Agency Owner</h3>
                <p>Agency owners can create, edit, delete, and manage tour packages.</p>
            </div>

            <div class="card">
                <h3>Tour Guide</h3>
                <p>Tour guides can view assigned tours and update tour progress.</p>
            </div>

            <div class="card">
                <h3>Super Admin</h3>
                <p>Admin can monitor users, bookings, payments, and system revenue.</p>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="stat">
            <h2>4</h2>
            <p>User Roles</p>
        </div>

        <div class="stat">
            <h2>20+</h2>
            <p>Functional Features</p>
        </div>

        <div class="stat">
            <h2>MVC</h2>
            <p>Laravel Architecture</p>
        </div>

        <div class="stat">
            <h2>MySQL</h2>
            <p>Database System</p>
        </div>
    </section>

    <div class="footer">
        Smart Tourism & Travel Marketplace | CSE470 Project
    </div>

</body>
</html>