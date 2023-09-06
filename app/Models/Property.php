<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = ['county', 'country', 'town', 'description', 'displayableAddress', 'image', 'thumnail', 'latitude', 'longitude', 'num_bedrooms', 'num_bathrooms', 'price', 'property_type_id', 'type'];
    public function propertyType(){
        return $this->belongsTo(PropertyType::class);
    }
}
