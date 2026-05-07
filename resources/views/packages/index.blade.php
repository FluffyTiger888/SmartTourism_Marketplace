<!DOCTYPE html>
<html>
<head>
    <title>Tour Packages</title>

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

        .top h1 {
            color: #1B4332;
            margin: 0;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn,
        .top a {
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

        .filter-box {
            background: white;
            padding: 22px;
            border-radius: 18px;
            margin-bottom: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.06);
        }

        .filter-title {
            color: #1B4332;
            margin-top: 0;
            margin-bottom: 18px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 16px;
        }

        .filter-group label {
            display: block;
            font-weight: bold;
            color: #1B4332;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 9px;
            box-sizing: border-box;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .reset-link {
            background: #6b7280;
            color: white;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }

        .result-count {
            color: #6b7280;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        .card h2 {
            color: #1B4332;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .tag {
            display: inline-block;
            background: #D8F3DC;
            color: #1B4332;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin: 3px;
        }

        .view-btn {
            display: inline-block;
            margin-top: 15px;
            background: #2D6A4F;
            color: white;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
        }

        .rating-box {
            background: #fff7ed;
            color: #9a3412;
            padding: 7px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .available {
            background: #dcfce7;
            color: #166534;
        }

        .unavailable {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
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
        }
    </style>
</head>

<body>

<div class="top">
    <h1>Available Tour Packages</h1>

    <div class="nav-actions">
        <a href="{{ route('home') }}">Home</a>

        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>

            @if(auth()->user()->role === 'agency_owner')
                <a href="{{ route('agency.packages.index') }}">Manage Packages</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-red">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</div>

<form method="GET" action="{{ route('packages.index') }}" class="filter-box">
    <h2 class="filter-title">Search and Filter Packages</h2>

    <div class="filter-grid">
        <div class="filter-group">
            <label>Search Keyword</label>
            <input
                type="text"
                name="search"
                placeholder="Search title, destination, tag"
                value="{{ request('search') }}"
            >
        </div>

        <div class="filter-group">
            <label>Destination</label>
            <input
                type="text"
                name="destination"
                placeholder="Example: Sylhet"
                value="{{ request('destination') }}"
            >
        </div>

        <div class="filter-group">
            <label>Minimum Price</label>
            <input
                type="number"
                name="min_price"
                placeholder="Example: 5000"
                value="{{ request('min_price') }}"
            >
        </div>

        <div class="filter-group">
            <label>Maximum Price</label>
            <input
                type="number"
                name="max_price"
                placeholder="Example: 20000"
                value="{{ request('max_price') }}"
            >
        </div>

        <div class="filter-group">
            <label>Maximum Duration</label>
            <input
                type="number"
                name="duration"
                placeholder="Days"
                value="{{ request('duration') }}"
            >
        </div>

        <div class="filter-group">
            <label>Tag</label>
            <input
                type="text"
                name="tag"
                placeholder="Example: beach"
                value="{{ request('tag') }}"
            >
        </div>

        <div class="filter-group">
            <label>Status</label>
            <select name="status">
                <option value="">Available Only</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Sort By</label>
            <select name="sort">
                <option value="">Latest</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="duration_asc" {{ request('sort') === 'duration_asc' ? 'selected' : '' }}>Duration: Shortest</option>
                <option value="duration_desc" {{ request('sort') === 'duration_desc' ? 'selected' : '' }}>Duration: Longest</option>
                <option value="rating_desc" {{ request('sort') === 'rating_desc' ? 'selected' : '' }}>Highest Rating</option>
            </select>
        </div>
    </div>

    <div class="filter-actions">
        <label style="display:flex; align-items:center; gap:8px; color:#1B4332; font-weight:bold;">
            <input
                type="checkbox"
                name="available_only"
                value="1"
                {{ request('available_only') ? 'checked' : '' }}
            >
            Seats Available Only
        </label>

        <button type="submit" class="btn">
            Apply Filters
        </button>

        <a href="{{ route('packages.index') }}" class="reset-link">
            Reset Filters
        </a>
    </div>
</form>

<div class="result-count">
    Showing {{ $packages->count() }} package(s)
</div>

<div class="grid">
    @forelse($packages as $package)
        <div class="card">
            <h2>{{ $package->title }}</h2>

            @php
                $avgRating = $package->reviews->avg('rating');
                $reviewCount = $package->reviews->count();
            @endphp

            @if($reviewCount > 0)
                <div class="rating-box">
                    ★ {{ number_format($avgRating, 1) }}/5 from {{ $reviewCount }} review(s)
                </div>
            @else
                <div class="rating-box">
                    No reviews yet
                </div>
            @endif

            <p>
                <strong>Status:</strong>
                <span class="status {{ $package->status }}">
                    {{ ucfirst($package->status) }}
                </span>
            </p>

            <p><strong>Destination:</strong> {{ $package->destination }}</p>
            <p><strong>Price:</strong> ৳{{ number_format($package->price, 2) }}</p>
            <p><strong>Duration:</strong> {{ $package->duration }} days</p>
            <p><strong>Available Seats:</strong> {{ $package->available_seats }}</p>

            @if($package->tags)
                <div>
                    @foreach(explode(',', $package->tags) as $tag)
                        <span class="tag">{{ trim($tag) }}</span>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('packages.show', $package->id) }}" class="view-btn">
                View Details
            </a>
        </div>
    @empty
        <div class="empty-card">
            <h2>No packages found.</h2>
            <p>No tour packages match your search or filter options.</p>
            <a href="{{ route('packages.index') }}" class="view-btn">
                Reset Search
            </a>
        </div>
    @endforelse
</div>

</body>
</html>