<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\TourPackage;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can access this dashboard.');
        }

        $totalRevenue = Payment::where('payment_status', 'successful')
            ->sum('amount');

        $totalBookings = Booking::count();

        $confirmedBookings = Booking::where('status', 'confirmed')
            ->count();

        $pendingBookings = Booking::where('status', 'pending')
            ->count();

        $cancelledBookings = Booking::where('status', 'cancelled')
            ->count();

        $totalCustomers = User::where('role', 'customer')
            ->count();

        $totalAgencies = User::where('role', 'agency_owner')
            ->count();

        $totalGuides = User::where('role', 'tour_guide')
            ->count();

        $totalPackages = TourPackage::count();

        $recentPayments = Payment::with([
                'booking.customer',
                'booking.tourPackage'
            ])
            ->latest()
            ->take(8)
            ->get();

        $successfulPayments = Payment::where('payment_status', 'successful')
            ->orderBy('created_at')
            ->get();

        $monthlyRevenue = $successfulPayments->groupBy(function ($payment) {
            return $payment->created_at->format('Y-m');
        });

        $chartLabels = [];
        $chartData = [];

        foreach ($monthlyRevenue as $month => $payments) {
            $chartLabels[] = date('F Y', strtotime($month . '-01'));
            $chartData[] = $payments->sum('amount');
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'cancelledBookings',
            'totalCustomers',
            'totalAgencies',
            'totalGuides',
            'totalPackages',
            'recentPayments',
            'chartLabels',
            'chartData'
        ));
    }

    public function users()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can manage users.');
        }

        $users = User::latest()->get();

        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        $customers = User::where('role', 'customer')->count();
        $agencies = User::where('role', 'agency_owner')->count();
        $guides = User::where('role', 'tour_guide')->count();
        $admins = User::where('role', 'super_admin')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'customers',
            'agencies',
            'guides',
            'admins'
        ));
    }

    public function toggleStatus(User $user)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Only super admin can update users.');
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot deactivate your own admin account.'
            ]);
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return back()->with('success', 'User status updated successfully.');
    }
}