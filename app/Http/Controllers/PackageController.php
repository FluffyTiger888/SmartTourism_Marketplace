<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function publicIndex(Request $request)
    {
        $query = TourPackage::query()
            ->with('reviews')
            ->withAvg('reviews', 'rating');

        /*
        |--------------------------------------------------------------------------
        | Basic Availability Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'available');
        }

        /*
        |--------------------------------------------------------------------------
        | Keyword Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('destination', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Destination Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('destination')) {
            $query->where('destination', 'LIKE', '%' . $request->destination . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Price Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        /*
        |--------------------------------------------------------------------------
        | Duration Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('duration')) {
            $query->where('duration', '<=', $request->duration);
        }

        /*
        |--------------------------------------------------------------------------
        | Tag Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tag')) {
            $query->where('tags', 'LIKE', '%' . $request->tag . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | Seat Availability Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('available_only')) {
            $query->where('available_seats', '>', 0);
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'duration_asc') {
                $query->orderBy('duration', 'asc');
            } elseif ($request->sort === 'duration_desc') {
                $query->orderBy('duration', 'desc');
            } elseif ($request->sort === 'rating_desc') {
                $query->orderBy('reviews_avg_rating', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $packages = $query->get();

        return view('packages.index', compact('packages'));
    }

    public function index()
    {
        $packages = TourPackage::where('agency_id', auth()->id())
            ->latest()
            ->get();

        return view('agency.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('agency.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable',
            'tags' => 'nullable|string|max:255',

            'itinerary_day_number' => 'nullable|array',
            'itinerary_day_number.*' => 'nullable|integer|min:1',
            'itinerary_title' => 'nullable|array',
            'itinerary_title.*' => 'nullable|string|max:255',
            'itinerary_description' => 'nullable|array',
            'itinerary_description.*' => 'nullable|string|max:1000',
        ]);

        $package = TourPackage::create([
            'agency_id' => auth()->id(),
            'title' => $request->title,
            'destination' => $request->destination,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'max_capacity' => $request->max_capacity,
            'available_seats' => $request->max_capacity,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);

        if ($request->has('itinerary_day_number')) {
            foreach ($request->itinerary_day_number as $index => $dayNumber) {
                $title = $request->itinerary_title[$index] ?? null;
                $description = $request->itinerary_description[$index] ?? null;

                if ($dayNumber && $title) {
                    $package->itineraries()->create([
                        'day_number' => $dayNumber,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
        }

        return redirect()
            ->route('agency.packages.index')
            ->with('success', 'Tour package created successfully.');
    }

    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load('reviews.customer', 'itineraries');

        $tagList = [];

        if (!empty($tourPackage->tags)) {
            $tagList = array_map('trim', explode(',', strtolower($tourPackage->tags)));
        }

        $recommendedPackages = TourPackage::query()
            ->where('id', '!=', $tourPackage->id)
            ->where('status', 'available')
            ->where(function ($query) use ($tourPackage, $tagList) {
                $query->where('destination', 'LIKE', '%' . $tourPackage->destination . '%');

                foreach ($tagList as $tag) {
                    if (!empty($tag)) {
                        $query->orWhere('tags', 'LIKE', '%' . $tag . '%');
                    }
                }

                $minPrice = $tourPackage->price * 0.75;
                $maxPrice = $tourPackage->price * 1.25;

                $query->orWhereBetween('price', [$minPrice, $maxPrice]);
            })
            ->limit(4)
            ->get();

        return view('packages.show', compact('tourPackage', 'recommendedPackages'));
    }

    public function edit(TourPackage $package)
    {
        if ($package->agency_id !== auth()->id()) {
            abort(403);
        }

        $package->load('itineraries');

        return view('agency.packages.edit', compact('package'));
    }

    public function update(Request $request, TourPackage $package)
    {
        if ($package->agency_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable',
            'tags' => 'nullable|string|max:255',

            'itinerary_day_number' => 'nullable|array',
            'itinerary_day_number.*' => 'nullable|integer|min:1',
            'itinerary_title' => 'nullable|array',
            'itinerary_title.*' => 'nullable|string|max:255',
            'itinerary_description' => 'nullable|array',
            'itinerary_description.*' => 'nullable|string|max:1000',
        ]);

        $oldMaxCapacity = $package->max_capacity;
        $oldAvailableSeats = $package->available_seats;
        $bookedSeats = $oldMaxCapacity - $oldAvailableSeats;

        $newAvailableSeats = $request->max_capacity - $bookedSeats;

        if ($newAvailableSeats < 0) {
            return back()->withErrors([
                'max_capacity' => 'New capacity cannot be lower than already booked seats.'
            ]);
        }

        $package->update([
            'title' => $request->title,
            'destination' => $request->destination,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'max_capacity' => $request->max_capacity,
            'available_seats' => $newAvailableSeats,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);

        $package->itineraries()->delete();

        if ($request->has('itinerary_day_number')) {
            foreach ($request->itinerary_day_number as $index => $dayNumber) {
                $title = $request->itinerary_title[$index] ?? null;
                $description = $request->itinerary_description[$index] ?? null;

                if ($dayNumber && $title) {
                    $package->itineraries()->create([
                        'day_number' => $dayNumber,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
        }

        return redirect()
            ->route('agency.packages.index')
            ->with('success', 'Tour package updated successfully.');
    }

    public function destroy(TourPackage $package)
    {
        if ($package->agency_id !== auth()->id()) {
            abort(403);
        }

        $package->delete();

        return redirect()
            ->route('agency.packages.index')
            ->with('success', 'Tour package deleted successfully.');
    }
}