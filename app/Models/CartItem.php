<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable =[
        'cart_id',
        'event_id',
        'time_slot_id',
        'vehicle_id',
        'expires_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
        ];
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

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

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
