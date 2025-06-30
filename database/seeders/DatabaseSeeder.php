<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Booking;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\eventsFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Event::factory()->count(20)->create();
        Booking::factory()->count(20)->create();
    }
}
