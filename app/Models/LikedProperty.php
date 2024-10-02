<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedProperty extends Model
{
    use HasFactory;

    protected $table = "liked_properties";
    protected $fillable = ['user_id', 'property_id'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Property (Listing)
    public function property()
    {
        return $this->belongsTo(Listing::class);
    }
}
