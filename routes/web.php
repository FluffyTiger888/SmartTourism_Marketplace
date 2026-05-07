<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\PerformanceController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/packages', [PackageController::class, 'publicIndex'])
    ->name('packages.index');

Route::get('/packages/{tourPackage}', [PackageController::class, 'show'])
    ->name('packages.show');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'agency_owner') {
            return redirect()->route('agency.packages.index');
        }

        if ($role === 'customer') {
            return redirect()->route('customer.bookings.index');
        }

        if ($role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'tour_guide') {
            return redirect()->route('guide.assignments.index');
        }

        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Agency Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:agency_owner'])
    ->prefix('agency')
    ->name('agency.')
    ->group(function () {
        Route::resource('packages', PackageController::class)
            ->except(['show']);

        Route::get('/bookings', [BookingController::class, 'agencyBookings'])
            ->name('bookings.index');

        Route::post('/bookings/{booking}/assign-guide', [BookingController::class, 'assignGuide'])
            ->name('bookings.assignGuide');

        Route::get('/performance', [PerformanceController::class, 'agencyPerformance'])
            ->name('performance.index');
    });

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::post('/packages/{tourPackage}/book', [BookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('/bookings', [BookingController::class, 'customerBookings'])
            ->name('bookings.index');

        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
            ->name('bookings.cancel');

        Route::get('/bookings/{booking}/payment', [PaymentController::class, 'checkout'])
            ->name('payments.checkout');

        Route::post('/bookings/{booking}/payment', [PaymentController::class, 'pay'])
            ->name('payments.pay');

        Route::get('/bookings/{booking}/payment/success', [PaymentController::class, 'success'])
            ->name('payments.success');

        Route::get('/packages/{tourPackage}/review', [ReviewController::class, 'create'])
            ->name('reviews.create');

        Route::post('/packages/{tourPackage}/review', [ReviewController::class, 'store'])
            ->name('reviews.store');
    });

/*
|--------------------------------------------------------------------------
| Tour Guide Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:tour_guide'])
    ->prefix('guide')
    ->name('guide.')
    ->group(function () {
        Route::get('/assignments', [GuideController::class, 'assignments'])
            ->name('assignments.index');

        Route::post('/assignments/{assignment}/status', [GuideController::class, 'updateStatus'])
            ->name('assignments.status');
    });

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users.index');

        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])
            ->name('users.toggle');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';