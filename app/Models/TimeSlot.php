<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function escapeRoom()
    {
        return $this->belongsTo(EscapeRoom::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
