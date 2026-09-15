<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    // Allow these columns to be saved via your Controller
    protected $fillable = [
        'name',
    ];

    // A province has many hotels
    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }
}
