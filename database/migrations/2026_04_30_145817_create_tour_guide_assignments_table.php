<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_guide_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->onDelete('cascade');

            $table->foreignId('tour_guide_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_guide_assignments');
    }
};