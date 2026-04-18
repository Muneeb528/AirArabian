<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@airarbian.com')],
            [
                'name'     => 'Travel Portal Admin',
                'email'    => env('ADMIN_EMAIL', 'admin@airarbian.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@1234')),
                'role'     => 'admin',
            ]
        );

        // ── Default Agency Settings ─────────────────────────────────────────
        $defaults = [
            'agency_name' => 'Travel Portal',
            'city'        => 'Karachi',
            'email'       => env('ADMIN_EMAIL', 'admin@airarbian.com'),
            'mobile'      => '+92 300 0000000',
        ];
        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // ── Sample Tickets ──────────────────────────────────────────────────
        $tickets = [
            ['category' => 'UAE',   'title' => 'Dubai Business Class',   'origin' => 'Karachi',   'destination' => 'Dubai',    'price' => 45000,  'seats_available' => 10, 'airline' => 'Emirates',            'departure_date' => now()->addDays(7)],
            ['category' => 'UAE',   'title' => 'Abu Dhabi Economy',       'origin' => 'Lahore',    'destination' => 'Abu Dhabi','price' => 32000,  'seats_available' => 15, 'airline' => 'Etihad',              'departure_date' => now()->addDays(14)],
            ['category' => 'UAE',   'title' => 'Sharjah Special',         'origin' => 'Islamabad', 'destination' => 'Sharjah',  'price' => 28000,  'seats_available' => 20, 'airline' => 'Air Arabia',          'departure_date' => now()->addDays(10)],
            ['category' => 'KSA',   'title' => 'Riyadh Economy',          'origin' => 'Karachi',   'destination' => 'Riyadh',   'price' => 38000,  'seats_available' => 12, 'airline' => 'Saudia',              'departure_date' => now()->addDays(5)],
            ['category' => 'KSA',   'title' => 'Jeddah Business',         'origin' => 'Lahore',    'destination' => 'Jeddah',   'price' => 52000,  'seats_available' => 8,  'airline' => 'Saudia',              'departure_date' => now()->addDays(12)],
            ['category' => 'KSA',   'title' => 'Dammam Special',          'origin' => 'Islamabad', 'destination' => 'Dammam',   'price' => 35000,  'seats_available' => 18, 'airline' => 'flyadeal',            'departure_date' => now()->addDays(20)],
            ['category' => 'Umrah', 'title' => 'Umrah Package Premium',   'origin' => 'Karachi',   'destination' => 'Makkah',   'price' => 75000,  'seats_available' => 5,  'airline' => 'PIA',                 'departure_date' => now()->addDays(21)],
            ['category' => 'Umrah', 'title' => 'Umrah Economy Package',   'origin' => 'Lahore',    'destination' => 'Madinah',  'price' => 55000,  'seats_available' => 20, 'airline' => 'Saudia',              'departure_date' => now()->addDays(30)],
            ['category' => 'Tour',  'title' => 'Istanbul Tour 7 Days',    'origin' => 'Karachi',   'destination' => 'Istanbul', 'price' => 120000, 'seats_available' => 10, 'airline' => 'Turkish Airlines',    'departure_date' => now()->addDays(45)],
            ['category' => 'Tour',  'title' => 'Baku Tour Package',       'origin' => 'Islamabad', 'destination' => 'Baku',     'price' => 95000,  'seats_available' => 8,  'airline' => 'Azerbaijan Airlines', 'departure_date' => now()->addDays(60)],
        ];

        foreach ($tickets as $ticket) {
            Ticket::firstOrCreate(
                ['title' => $ticket['title'], 'category' => $ticket['category']],
                array_merge($ticket, ['status' => Ticket::STATUS_AVAILABLE])
            );
        }

        // ── Bank Accounts ───────────────────────────────────────────────────
        $this->call(BankAccountSeeder::class);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('   Admin: ' . env('ADMIN_EMAIL', 'admin@airarbian.com'));
        $this->command->info('   Pass:  ' . env('ADMIN_PASSWORD', 'Admin@1234'));
    }
}
