<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'province_id',
        'user_id',
        'name',
        'description',
        'price_per_night',
        'address',
        'star_rating',
        'website_url',
        'facebook_url',
        'google_maps_url',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'hotel_amenities');
    }
}
