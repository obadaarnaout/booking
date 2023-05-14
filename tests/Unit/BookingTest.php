<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Booking;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsUserBookings()
    {
        $user = User::factory()->create();
        $bookings = Booking::factory()->count(5)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get('/api/bookings');

        $response->assertStatus(200)
            ->assertJson($bookings->toArray());
    }
    public function testStoreCreatesNewBooking()
    {
        $user = User::factory()->create();
        $escapeRoom = EscapeRoom::factory()->create();
        $timeSlot = TimeSlot::factory()->create(['escape_room_id' => $escapeRoom->id]);

        $data = [
            'room_id' => $timeSlot->escape_room_id,
            'time_id' => $timeSlot->id,
        ];

        $payload = [
            'escape_room_id' => $timeSlot->escape_room_id,
            'time_slot_id' => $timeSlot->id,
        ];

        $response = $this->actingAs($user)
            ->post('/api/bookings', $data);

        $response->assertStatus(200)
            ->assertJson($payload);

        $this->assertDatabaseHas('bookings', $payload);
    }

    public function testDestroyDeletesBooking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete('/api/bookings/' . $booking->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Booking cancelled successfully.']);

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}