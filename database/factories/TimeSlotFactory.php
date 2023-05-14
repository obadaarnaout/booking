<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\EscapeRoom;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->copy()->addWeeks(2)->format('Y-m-d H:i:s');
        return [
            'date' => fake()->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
            'escape_room_id' => function () {
                return EscapeRoom::factory(EscapeRoom::class)->create()->id;
            },
            'max_participants' => fake()->numberBetween(1, 10),
        ];
    }
}
