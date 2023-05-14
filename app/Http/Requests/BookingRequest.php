<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:escape_rooms,id'],
            'time_id' => ['required', 'exists:time_slots,id']
        ];
    }

    public function checkHasBooked()
    {
        $existingBooking = Booking::where('user_id', $this->user()->id)
            ->where('escape_room_id', $this->room_id)
            ->where('time_slot_id', $this->time_id)
            ->count();

        if ($existingBooking > 0) {
            throw new HttpResponseException(response()->json([
                'message' => 'You have already booked this escape room and time slot.'
            ],422));
        }
    }

    public function checkFullyBooked()
    {
        $timeSlot = TimeSlot::where('id', $this->time_id)->where('escape_room_id', $this->room_id)->first();

        if(!$timeSlot){
            throw new HttpResponseException(response()->json([
                'message' => 'Time Slot not found'
            ],422));
        }

        if ($timeSlot->max_participants == 0) {
            throw new HttpResponseException(response()->json([
                'message' => 'The escape room is fully booked for this time slot.'
            ],422));
        }
        $this->request->add(['timeSlot' => $timeSlot]);
    }

    public function withValidator($validator)
    {
        $this->checkHasBooked();
        $this->checkFullyBooked();
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first()
        ],422));
    }
}
