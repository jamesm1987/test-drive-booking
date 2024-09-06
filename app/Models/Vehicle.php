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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_vehicle')
                    ->withPivot('attribute_value_id')
                    ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_vehicle')
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


}
