<!DOCTYPE html>
<html>
<head>
    <title>Admin User Management</title>

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

        .btn-blue {
            background: #2563eb;
        }

        .btn-gray {
            background: #6b7280;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
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

        .section {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
            margin-bottom: 30px;
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

        .role {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .active {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
            background: #fee2e2;
            color: #991b1b;
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
    <h1>Admin User Management</h1>

    <div class="nav-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-blue">Financial Dashboard</a>
        <a href="{{ route('packages.index') }}" class="btn">Browse Packages</a>
        <a href="{{ route('home') }}" class="btn btn-gray">Home</a>

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

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <h2>{{ $totalUsers }}</h2>
    </div>

    <div class="stat-card blue">
        <h3>Active Users</h3>
        <h2>{{ $activeUsers }}</h2>
    </div>

    <div class="stat-card red">
        <h3>Inactive Users</h3>
        <h2>{{ $inactiveUsers }}</h2>
    </div>

    <div class="stat-card">
        <h3>Customers</h3>
        <h2>{{ $customers }}</h2>
    </div>

    <div class="stat-card orange">
        <h3>Agencies</h3>
        <h2>{{ $agencies }}</h2>
    </div>

    <div class="stat-card purple">
        <h3>Tour Guides</h3>
        <h2>{{ $guides }}</h2>
    </div>

    <div class="stat-card blue">
        <h3>Admins</h3>
        <h2>{{ $admins }}</h2>
    </div>
</div>

<div class="section">
    <h2>All Users</h2>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>

                    <td>
                        {{ $user->name }}

                        @if($user->id === auth()->id())
                            <br>
                            <span class="muted">Current account</span>
                        @endif
                    </td>

                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="role">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>

                    <td>
                        {{ $user->phone ?? 'N/A' }}
                    </td>

                    <td>
                        @if($user->is_active)
                            <span class="active">Active</span>
                        @else
                            <span class="inactive">Inactive</span>
                        @endif
                    </td>

                    <td>
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}">
                                @csrf

                                @if($user->is_active)
                                    <button type="submit" class="btn btn-red">
                                        Deactivate
                                    </button>
                                @else
                                    <button type="submit" class="btn">
                                        Activate
                                    </button>
                                @endif
                            </form>
                        @else
                            <span class="muted">Not allowed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>