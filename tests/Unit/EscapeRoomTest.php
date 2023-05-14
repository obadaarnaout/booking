<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Booking;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;

class EscapeRoomTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsAllEscapeRooms()
    {
        $escapeRooms = EscapeRoom::factory()->count(5)->create();

        $response = $this->get('/api/escape-rooms');

        $response->assertStatus(200)
            ->assertJson($escapeRooms->toArray());
    }

    public function testShowReturnsSpecificEscapeRoom()
    {
        $escapeRoom = EscapeRoom::factory()->create();

        $response = $this->get('/api/escape-rooms/' . $escapeRoom->id);

        $response->assertStatus(200)
            ->assertJson($escapeRoom->toArray());
    }

    public function testTimeSlotsReturnsTimeSlotsForEscapeRoom()
    {
        $escapeRoom = EscapeRoom::factory()->create();
        $timeSlots = TimeSlot::factory()->count(5)->create(['escape_room_id' => $escapeRoom->id]);

        $response = $this->get('/api/escape-rooms/' . $escapeRoom->id . '/time-slots');

        $response->assertStatus(200)
            ->assertJson($timeSlots->toArray());
    }
}
