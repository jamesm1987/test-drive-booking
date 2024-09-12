<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'img_url',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'time_slot_interval'
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'event_vehicle');
    }

    public function timeslots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
