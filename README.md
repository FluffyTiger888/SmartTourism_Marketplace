# Smart Tourism & Travel Marketplace

## Project Overview

Smart Tourism & Travel Marketplace is a Laravel-based web application for managing tourism packages, bookings, payments, reviews, tour guides, and admin monitoring.

The system connects customers, travel agency owners, tour guides, and super admins through a single platform. Customers can browse and book tour packages, agencies can manage packages and assign guides, tour guides can track assigned tours, and admins can monitor users, revenue, bookings, and system activity.

The system follows the MVC architecture using Laravel.

---

## Technology Stack

### Frontend
- HTML
- CSS
- Blade Template Engine

### Backend
- PHP
- Laravel Framework

### Database
- MySQL / SQLite

### Authentication
- Laravel Breeze Authentication

### Version Control
- GitHub

---

## User Roles

The system has four main user roles:

1. Super Admin
2. Travel Agency Owner
3. Customer
4. Tour Guide

Each role has different permissions and dashboard access.

---

## Completed Features

### 1. Multi-Role Authentication and RBAC

The system supports role-based authentication.

Roles include:

- Super Admin
- Agency Owner
- Customer
- Tour Guide

Users are redirected to different dashboards based on their role.

Role-based middleware protects routes from unauthorized access.

---

### 2. Custom Login and Registration Interface

The default Laravel login/register interface was replaced with a custom tourism-themed interface.

The interface includes:

- Travel background
- Smart Tourism Marketplace branding
- Custom login card
- Custom register form
- Role selection during registration

---

### 3. Logout System

Logout buttons are available across important pages, including:

- Dashboard
- Package listing
- Package details
- Booking page
- Payment page
- Admin dashboard
- Guide dashboard
- Agency pages

---

### 4. Tour Package CRUD

Agency owners can manage tour packages.

Agency owners can:

- Create tour packages
- View their packages
- Edit packages
- Delete packages
- Set destination
- Set price
- Set duration
- Set maximum traveller capacity
- Set package availability
- Add package tags

---

### 5. Itinerary Builder

Agency owners can add day-wise itineraries to tour packages.

Example:

- Day 1: Arrival and hotel check-in
- Day 2: Sightseeing
- Day 3: Return journey

Itineraries are displayed on the public package details page.

---

### 6. Capacity and Inventory Management

Each package has:

- Maximum capacity
- Available seats

When a customer books a package, available seats decrease.

When a pending booking is cancelled, seats are restored.

The system prevents overbooking beyond package capacity.

---

### 7. Smart Search and Robust Filtering

Customers can search and filter tour packages using:

- Keyword search
- Destination
- Minimum price
- Maximum price
- Duration
- Tags
- Availability
- Sorting by latest
- Sorting by price
- Sorting by duration
- Sorting by rating

---

### 8. Smart Recommendation Engine

The system includes a rule-based recommendation system.

Recommendations are based on:

- Similar destination
- Similar tags
- Similar price range

This allows the system to recommend related packages without using complex machine learning.

---

### 9. Booking Engine

Customers can book tour packages.

The system stores:

- Customer ID
- Package ID
- Number of travellers
- Total price
- Booking date
- Booking status

Initial booking status is set to pending.

---

### 10. Booking Cancellation

Customers can cancel pending bookings.

When a pending booking is cancelled, the system restores the available seats to the tour package.

Confirmed bookings cannot be cancelled from the customer booking page.

---

### 11. Sandbox Payment System

The system includes a sandbox payment page for demo purposes.

Customers can enter demo card details.

After successful payment:

- Payment record is stored
- Transaction ID is generated
- Booking status becomes confirmed

No real money is charged.

---

### 12. Booking Confirmation

After a successful payment, customers see a payment success page.

The page displays:

- Booking ID
- Package name
- Destination
- Number of people
- Total paid
- Transaction ID
- Payment status
- Booking status

---

### 13. Review and Rating System

Customers can review a package after confirming a booking.

Customers can submit:

- Rating from 1 to 5
- Written comment

The system displays:

- Average rating
- Total reviews
- Customer comments

Reviews appear on the package details page.

---

### 14. Admin Financial Dashboard

The super admin can monitor financial and booking data.

Admin dashboard includes:

- Total revenue
- Total bookings
- Confirmed bookings
- Pending bookings
- Cancelled bookings
- Total customers
- Total agencies
- Total tour guides
- Total packages
- Recent payment transactions
- Monthly revenue chart

---

### 15. Guide Assignment and Management

Agency owners can assign tour guides to confirmed bookings.

Tour guides can view assigned tours and update tour status.

Tour status options:

- Upcoming
- Ongoing
- Completed

---

### 16. Agency Performance Monitoring

Agency owners can monitor their performance.

Performance dashboard includes:

- Total packages
- Total bookings
- Confirmed bookings
- Pending bookings
- Cancelled bookings
- Total revenue
- Average rating
- Total reviews
- Completed tours
- Top packages by bookings
- Recent customer feedback

Performance status is calculated from ratings and reviews.

Possible statuses:

- Excellent
- Good
- Average
- Needs Improvement
- Not Enough Data

---

### 17. Super Admin User Management

Super admin can manage users.

Admin can:

- View all users
- See user roles
- See active/inactive status
- Activate users
- Deactivate users

The admin cannot deactivate their own account.

---

### 18. Data Security

The system includes several security features:

- CSRF protection
- Password hashing
- Input validation
- Role-based middleware
- Route-level protection
- Ownership checking
- SQL injection protection through Laravel Eloquent ORM
- Custom 403 Access Denied page

---

## Database Tables

The system uses the following main tables:

1. users
2. tour_packages
3. itineraries
4. bookings
5. payments
6. reviews
7. tour_guide_assignments

---

## MVC Architecture

### Models

Models represent database tables and relationships.

Main models:

- User
- TourPackage
- Itinerary
- Booking
- Payment
- Review
- TourGuideAssignment

---

### Views

Views display the user interface using Blade templates.

Important view folders:

- resources/views/auth
- resources/views/packages
- resources/views/customer/bookings
- resources/views/customer/payments
- resources/views/customer/reviews
- resources/views/agency/packages
- resources/views/agency/bookings
- resources/views/agency/performance
- resources/views/admin
- resources/views/guide
- resources/views/errors

---

### Controllers

Controllers handle system logic.

Main controllers:

- PackageController
- BookingController
- PaymentController
- ReviewController
- AdminController
- GuideController
- PerformanceController

---

## Default Demo Accounts

Use these accounts for testing.

### Super Admin

Email:

```text
admin@travelmarket.com