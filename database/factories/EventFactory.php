<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory  extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+10 days');
        $end = (clone $start)->modify('+2 hours');
        $totalSeats = $this->faker->numberBetween(30, 100);
        return [
            'title'           => $this->faker->sentence(3),
            'description'     => $this->faker->paragraph,
            'start_time'      => $start,
            'end_time'        => $end,
            'location'        => $this->faker->city,
            'total_seats'     => $totalSeats,
            'available_seats' => $totalSeats,
        ];
    }
}
