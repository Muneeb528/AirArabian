<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['UAE', 'KSA', 'Umrah', 'Tour']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('airline')->nullable();
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('seats_available')->default(1);
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['available', 'booked', 'hold', 'cancelled'])->default('available');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
