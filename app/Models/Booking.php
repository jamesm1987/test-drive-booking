<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 
        'time_slot_id', 
        'vehicle_id', 
        'name', 
        'email',
        'phone'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
