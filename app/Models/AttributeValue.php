<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'attribute_id'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'attribute_vehicle')
            ->using(AttributeVehicle::class)
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
}
