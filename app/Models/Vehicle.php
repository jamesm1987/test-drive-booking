<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'number',
        'model',
        'manufacturer_id',
        'slug',
        'registration',
        'img_url',

    ];


    /**
     * Get the attributes associated with the vehicle.
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_vehicle')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    /**
     * Get the attribute values associated with the vehicle.
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_vehicle', 'vehicle_id', 'attribute_value_id')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
    
    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot('max_bookings_per_timeslot')->withTimestamps();
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    } 

    public function vehicleAttributes()
    {
        return $this->hasMany(AttributeVehicle::class);
    }


}
