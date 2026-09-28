<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenities');
    }
}