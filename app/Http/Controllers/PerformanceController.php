<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\TourPackage;
use App\Models\TourGuideAssignment;

class PerformanceController extends Controller
{
    public function agencyPerformance()
    {
        if (auth()->user()->role !== 'agency_owner') {
            abort(403, 'Only agency owners can access performance monitoring.');
        }

        $agencyId = auth()->id();

        $packageIds = TourPackage::where('agency_id', $agencyId)
            ->pluck('id');

        $totalPackages = $packageIds->count();

        $totalBookings = Booking::whereIn('tour_package_id', $packageIds)
            ->count();

        $confirmedBookings = Booking::whereIn('tour_package_id', $packageIds)
            ->where('status', 'confirmed')
            ->count();

        $pendingBookings = Booking::whereIn('tour_package_id', $packageIds)
            ->where('status', 'pending')
            ->count();

        $cancelledBookings = Booking::whereIn('tour_package_id', $packageIds)
            ->where('status', 'cancelled')
            ->count();

        $confirmedBookingIds = Booking::whereIn('tour_package_id', $packageIds)
            ->where('status', 'confirmed')
            ->pluck('id');

        $totalRevenue = Payment::whereIn('booking_id', $confirmedBookingIds)
            ->where('payment_status', 'successful')
            ->sum('amount');

        $totalReviews = Review::whereIn('tour_package_id', $packageIds)
            ->count();

        $averageRating = Review::whereIn('tour_package_id', $packageIds)
            ->avg('rating');

        $completedTours = TourGuideAssignment::whereIn('booking_id', $confirmedBookingIds)
            ->where('status', 'completed')
            ->count();

        if ($totalReviews === 0) {
            $performanceStatus = 'Not Enough Data';
            $performanceClass = 'neutral';
        } elseif ($averageRating >= 4.5) {
            $performanceStatus = 'Excellent';
            $performanceClass = 'excellent';
        } elseif ($averageRating >= 3.5) {
            $performanceStatus = 'Good';
            $performanceClass = 'good';
        } elseif ($averageRating >= 2.5) {
            $performanceStatus = 'Average';
            $performanceClass = 'average';
        } else {
            $performanceStatus = 'Needs Improvement';
            $performanceClass = 'poor';
        }

        $topPackages = TourPackage::withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->where('agency_id', $agencyId)
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        $recentReviews = Review::with('customer', 'tourPackage')
            ->whereIn('tour_package_id', $packageIds)
            ->latest()
            ->take(6)
            ->get();

        return view('agency.performance.index', compact(
            'totalPackages',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'cancelledBookings',
            'totalRevenue',
            'totalReviews',
            'averageRating',
            'completedTours',
            'performanceStatus',
            'performanceClass',
            'topPackages',
            'recentReviews'
        ));
    }
}