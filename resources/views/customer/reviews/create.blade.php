<!DOCTYPE html>
<html>
<head>
    <title>Review Package</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 760px;
            margin: auto;
            background: white;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1, h2 {
            color: #1B4332;
        }

        .group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #1B4332;
            margin-bottom: 7px;
        }

        select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 130px;
        }

        .btn {
            background: #2D6A4F;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-red {
            background: #dc2626;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-box {
            background: #D8F3DC;
            color: #1B4332;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top-actions">
        <a href="{{ route('customer.bookings.index') }}" class="btn">My Bookings</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>

    <h1>Review Tour Package</h1>

    <div class="info-box">
        <strong>Package:</strong> {{ $tourPackage->title }} <br>
        <strong>Destination:</strong> {{ $tourPackage->destination }}
    </div>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('customer.reviews.store', $tourPackage->id) }}">
        @csrf

        <div class="group">
            <label>Rating</label>

            <select name="rating" required>
                <option value="">Select Rating</option>
                <option value="5" {{ old('rating', $existingReview->rating ?? '') == 5 ? 'selected' : '' }}>5 - Excellent</option>
                <option value="4" {{ old('rating', $existingReview->rating ?? '') == 4 ? 'selected' : '' }}>4 - Very Good</option>
                <option value="3" {{ old('rating', $existingReview->rating ?? '') == 3 ? 'selected' : '' }}>3 - Good</option>
                <option value="2" {{ old('rating', $existingReview->rating ?? '') == 2 ? 'selected' : '' }}>2 - Fair</option>
                <option value="1" {{ old('rating', $existingReview->rating ?? '') == 1 ? 'selected' : '' }}>1 - Poor</option>
            </select>
        </div>

        <div class="group">
            <label>Comment</label>

            <textarea name="comment" placeholder="Write your experience here">{{ old('comment', $existingReview->comment ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn">
            {{ $existingReview ? 'Update Review' : 'Submit Review' }}
        </button>

        <a href="{{ route('packages.show', $tourPackage->id) }}" class="btn">
            View Package
        </a>
    </form>

</div>

</body>
</html>