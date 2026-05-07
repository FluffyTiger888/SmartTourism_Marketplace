<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agency_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('title');
            $table->string('destination');
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->integer('duration');

            $table->integer('max_capacity');
            $table->integer('available_seats');

            $table->enum('status', ['available', 'unavailable'])->default('available');

            // Used for recommendation system
            $table->string('tags')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};