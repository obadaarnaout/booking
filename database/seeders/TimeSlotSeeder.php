<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSlot;
use App\Models\EscapeRoom;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $escapeRooms = EscapeRoom::factory()->count(10)->create();

        foreach ($escapeRooms as $escapeRoom) {
            TimeSlot::factory()->count(10)->create([
                'escape_room_id' => $escapeRoom->id,
            ]);
        }
    }
}
