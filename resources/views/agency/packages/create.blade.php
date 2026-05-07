<!DOCTYPE html>
<html>
<head>
    <title>Create Tour Package</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 850px;
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

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
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
            font-size: 14px;
        }

        .btn-red {
            background: #dc2626;
        }

        .btn-orange {
            background: #f97316;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .itinerary-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 16px;
        }

        .row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 12px;
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
        <h1>Create Tour Package</h1>
        <a href="{{ route('agency.packages.index') }}" class="btn">Back</a>
    </div>

    @if($errors->any())
        <div class="error">
            <strong>Please fix these errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agency.packages.store') }}">
        @csrf

        <div class="group">
            <label>Package Title</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Example: Cox's Bazar Beach Tour" required>
        </div>

        <div class="group">
            <label>Destination</label>
            <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Example: Cox's Bazar" required>
        </div>

        <div class="group">
            <label>Description</label>
            <textarea name="description" placeholder="Write package details">{{ old('description') }}</textarea>
        </div>

        <div class="group">
            <label>Price</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Example: 12000" required>
        </div>

        <div class="group">
            <label>Duration</label>
            <input type="number" name="duration" value="{{ old('duration') }}" placeholder="Number of days" required>
        </div>

        <div class="group">
            <label>Maximum Traveller Capacity</label>
            <input type="number" name="max_capacity" value="{{ old('max_capacity') }}" placeholder="Example: 20" required>
        </div>

        <div class="group">
            <label>Status</label>
            <select name="status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>

        <div class="group">
            <label>Package Tags</label>
            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Example: beach, family, adventure">
            <small>Use commas between tags. These tags are used for recommendations.</small>
        </div>

        <hr>

        <h2>Day-wise Itinerary</h2>

        <div id="itinerary-wrapper">
            <div class="itinerary-card">
                <div class="row">
                    <div class="group">
                        <label>Day</label>
                        <input type="number" name="itinerary_day_number[]" value="1" min="1">
                    </div>

                    <div class="group">
                        <label>Title</label>
                        <input type="text" name="itinerary_title[]" placeholder="Example: Arrival and hotel check-in">
                    </div>
                </div>

                <div class="group">
                    <label>Description</label>
                    <textarea name="itinerary_description[]" placeholder="Write activities for this day"></textarea>
                </div>
            </div>
        </div>

        <button type="button" onclick="addItinerary()" class="btn btn-orange">
            + Add Another Day
        </button>

        <br><br>

        <button type="submit" class="btn">Save Package</button>
    </form>
</div>

<script>
    let dayCounter = 2;

    function addItinerary() {
        const wrapper = document.getElementById('itinerary-wrapper');

        const html = `
            <div class="itinerary-card">
                <div class="row">
                    <div class="group">
                        <label>Day</label>
                        <input type="number" name="itinerary_day_number[]" value="${dayCounter}" min="1">
                    </div>

                    <div class="group">
                        <label>Title</label>
                        <input type="text" name="itinerary_title[]" placeholder="Example: Sightseeing">
                    </div>
                </div>

                <div class="group">
                    <label>Description</label>
                    <textarea name="itinerary_description[]" placeholder="Write activities for this day"></textarea>
                </div>

                <button type="button" onclick="this.parentElement.remove()" class="btn btn-red">
                    Remove Day
                </button>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        dayCounter++;
    }
</script>

</body>
</html>