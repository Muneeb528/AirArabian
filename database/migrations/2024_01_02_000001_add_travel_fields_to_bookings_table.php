<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // New fields after existing ones
            $table->string('invoice_number')->nullable()->after('id');
            $table->string('pnr')->nullable()->after('invoice_number');
            $table->string('group_name')->nullable()->after('pnr');
            $table->string('category')->nullable()->after('group_name'); // Umrah Package, Umrah Tickets, etc.
            $table->date('travel_date')->nullable()->after('category');
            $table->date('return_date')->nullable()->after('travel_date');
            $table->unsignedInteger('adults')->default(1)->after('return_date');
            $table->unsignedInteger('children')->default(0)->after('adults');
            $table->timestamp('payment_deadline')->nullable()->after('children'); // 4-hour deadline
            $table->boolean('auto_cancel_notified')->default(false)->after('payment_deadline');
        });

        // Update status enum to include new statuses
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('hold','partial_sold','confirmed','cancelled','pending') DEFAULT 'hold'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number','pnr','group_name','category',
                'travel_date','return_date','adults','children',
                'payment_deadline','auto_cancel_notified',
            ]);
        });
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','cancelled') DEFAULT 'pending'");
    }
};
