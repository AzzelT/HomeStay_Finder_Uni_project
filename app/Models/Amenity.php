<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon', // If you are using icons for amenities
    ];

    // An amenity can belong to many hotels (Many-to-Many)
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenities');
    }
}
