<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('tour_package_id')
                ->constrained('tour_packages')
                ->onDelete('cascade');

            $table->integer('number_of_people');
            $table->decimal('total_price', 10, 2);

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            $table->date('booking_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};