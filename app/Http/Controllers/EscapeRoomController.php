<?php

namespace App\Http\Controllers;

use App\Models\EscapeRoom;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EscapeRoomController extends Controller
{
    public function index()
    {
        return response()->json(EscapeRoom::all());
    }

    public function show($id)
    {
        try {

            $escapeRoom = EscapeRoom::findOrFail($id);

            return response()->json($escapeRoom);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Escape room not found'], 404);
        }
    }

    public function timeSlots($id)
    {
        try {
            $escapeRoom = EscapeRoom::findOrFail($id);
            $timeSlots = $escapeRoom->timeSlots;

            return response()->json($timeSlots);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Escape room not found'], 404);
        }
    }
}
