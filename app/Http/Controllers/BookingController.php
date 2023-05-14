<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bookings = $user->bookings()->with('escapeRoom','timeSlot')->get();
        return response()->json($bookings);
    }

    public function store(BookingRequest $request)
    {
        $timeSlot = $request->get('timeSlot');
        $discount = 0;
        $user = $request->user();
        if ($timeSlot->date == $user->date_of_birth) {
            $discount = 1;
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'time_slot_id' => $timeSlot->id,
            'escape_room_id' => $request->input('room_id'),
            'discount_applied' => $discount,
        ]);

        $timeSlot->decrement('max_participants');

        return response()->json($booking);
    }

    public function destroy($id, Request $request)
    {
        try {
            $user = $request->user();
            $booking = Booking::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $booking->timeSlot()->increment('max_participants');
            $booking->delete();

            return response()->json(['message' => 'Booking cancelled successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Booking not found'], 422);
        }
    }
}
