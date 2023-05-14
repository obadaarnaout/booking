<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use App\Models\Booking;
use App\Models\EscapeRoom;
use App\Models\TimeSlot;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanCreateBooking()
    {
        // Create a user
        $user = User::factory()->create();

        // Create an escape room
        $escapeRoom = EscapeRoom::factory()->create();

        // Create a time slot for the escape room
        $timeSlot = TimeSlot::factory()->create(['escape_room_id' => $escapeRoom->id]);

        // Login the user
        $this->actingAs($user);

        // Send a POST request to create a booking
        $response = $this->post('/api/bookings', [
            'room_id' => $escapeRoom->id,
            'time_id' => $timeSlot->id,
        ]);

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the booking is created in the database
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'escape_room_id' => $escapeRoom->id,
            'time_slot_id' => $timeSlot->id,
        ]);
    }

    public function testUserCanViewTheirBookings()
    {
        // Create a user
        $user = User::factory()->create();

        // Create bookings for the user
        $bookings = Booking::factory()->count(3)->create(['user_id' => $user->id]);

        // Login the user
        $this->actingAs($user);

        // Send a GET request to fetch the user's bookings
        $response = $this->get('/api/bookings');

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the returned bookings match the user's bookings
        $response->assertJson($bookings->toArray());
    }

    public function testUserCanCancelBooking()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a booking for the user
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        // Login the user
        $this->actingAs($user);

        // Send a DELETE request to cancel the booking
        $response = $this->delete('/api/bookings/' . $booking->id);

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the booking is deleted from the database
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}
