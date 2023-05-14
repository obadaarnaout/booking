<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscapeRoom extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

}
