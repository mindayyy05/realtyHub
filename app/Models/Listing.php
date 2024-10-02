<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type',
        'bedrooms',
        'bathrooms',
        'garages',
        'land_size',
        'house_size',
        'price',
        'price_per_sqft',
        'address',
        'street_address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'title',
        'description',
        'real_estate_agent',
        'is_negotiable',
        'is_for_sale',
        'is_for_rent',
        'features',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'images',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'features' => 'array',
    ];
}
