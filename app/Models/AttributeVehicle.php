<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeVehicle extends Pivot
{

    protected $table = 'attribute_vehicle';

    protected $fillable = [
        'vehicle_id',
        'attribute_id',
        'attribute_value_id'
    ];

    protected $casts = [
        'attribute_value_id' => 'array',
    ];
    
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
