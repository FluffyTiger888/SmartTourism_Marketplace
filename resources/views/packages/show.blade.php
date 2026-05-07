<!DOCTYPE html>
<html>
<head>
    <title>{{ $tourPackage->title }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .main-card,
        .review-section {
            background: white;
            padding: 32px;
            border-radius: 22px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            margin-bottom: 35px;
        }

        h1, h2 {
            color: #1B4332;
        }

        .tag {
            display: inline-block;
            background: #D8F3DC;
            color: #1B4332;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin: 4px;
        }

        .btn {
            display: inline-block;
            background: #2D6A4F;
            color: white;
            padding: 11px 16px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-red {
            background: #dc2626;
        }

        .recommend-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
        }

        .recommend-card {
            background: white;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        .back {
            color: #2D6A4F;
            text-decoration: none;
            font-weight: bold;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 8px;
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

        .rating-box {
            background: #fff7ed;
            color: #9a3412;
            padding: 12px 16px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: bold;
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
    </style>
</head>

<body>

<div class="container">

    <div class="top-nav">
        <a href="{{ route('packages.index') }}" class="back">← Back to Packages</a>

        <div class="nav-actions">
            <a href="{{ route('home') }}" class="btn">Home</a>

            @auth
                <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-red">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn">Login</a>
            @endauth
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

    <div class="main-card">
        <h1>{{ $tourPackage->title }}</h1>

        @php
            $averageRating = $tourPackage->reviews->avg('rating');
            $reviewCount = $tourPackage->reviews->count();
        @endphp

        @if($reviewCount > 0)
            <div class="rating-box">
                ★ {{ number_format($averageRating, 1) }}/5 from {{ $reviewCount }} review(s)
            </div>
        @else
            <div class="rating-box">
                No reviews yet
            </div>
        @endif

        <p><strong>Destination:</strong> {{ $tourPackage->destination }}</p>
        <p><strong>Price:</strong> ৳{{ number_format($tourPackage->price, 2) }}</p>
        <p><strong>Duration:</strong> {{ $tourPackage->duration }} days</p>
        <p><strong>Available Seats:</strong> {{ $tourPackage->available_seats }} / {{ $tourPackage->max_capacity }}</p>
        <p><strong>Status:</strong> {{ ucfirst($tourPackage->status) }}</p>

        <p>
            <strong>Description:</strong><br>
            {{ $tourPackage->description }}
        </p>

        @if($tourPackage->tags)
            <p><strong>Tags:</strong></p>

            @foreach(explode(',', $tourPackage->tags) as $tag)
                <span class="tag">{{ trim($tag) }}</span>
            @endforeach
        @endif

        @auth
            @if(auth()->user()->role === 'customer')
                <form method="POST" action="{{ route('customer.bookings.store', $tourPackage->id) }}">
                    @csrf

                    <label style="display:block; margin-top:20px; font-weight:bold;">
                        Number of People
                    </label>

                    <input
                        type="number"
                        name="number_of_people"
                        min="1"
                        max="{{ $tourPackage->available_seats }}"
                        value="1"
                    >

                    <br>

                    <button type="submit" class="btn">
                        Book This Package
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn">
                Login to Book
            </a>
        @endauth
    </div>

    <div class="review-section">
        <h2>Customer Reviews</h2>

        @if($tourPackage->reviews->count() > 0)
            @foreach($tourPackage->reviews as $review)
                <div class="review-card">
                    <p class="stars">
                        Rating: {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                    </p>

                    <p>
                        {{ $review->comment ?? 'No comment provided.' }}
                    </p>

                    <p class="muted">
                        By {{ $review->customer->name ?? 'Customer' }}
                    </p>
                </div>
            @endforeach
        @else
            <p>No reviews have been submitted for this package yet.</p>
        @endif
    </div>

    @if(isset($recommendedPackages) && $recommendedPackages->count() > 0)
        <h2>Recommended Packages</h2>
        <p>Suggested based on destination, tags, and similar budget range.</p>

        <div class="recommend-grid">
            @foreach($recommendedPackages as $recommended)
                <div class="recommend-card">
                    <h3>{{ $recommended->title }}</h3>

                    <p><strong>Destination:</strong> {{ $recommended->destination }}</p>
                    <p><strong>Price:</strong> ৳{{ number_format($recommended->price, 2) }}</p>
                    <p><strong>Duration:</strong> {{ $recommended->duration }} days</p>

                    @if($recommended->tags)
                        @foreach(explode(',', $recommended->tags) as $tag)
                            <span class="tag">{{ trim($tag) }}</span>
                        @endforeach
                    @endif

                    <br>

                    <a href="{{ route('packages.show', $recommended->id) }}" class="btn">
                        View Package
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</div>

</body>
</html>