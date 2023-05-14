<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'escape_room_id' => function () {
                return EscapeRoom::factory()->create()->id;
            },
            'time_slot_id' => function () {
                return TimeSlot::factory()->create()->id;
            },
        ];
    }
}
