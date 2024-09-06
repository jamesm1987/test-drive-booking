<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttributeSelectType;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'option_type',  
    ];
    
    protected $casts = [
        'option_type' => AttributeSelectType::class,
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'attibute_vehicle')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
