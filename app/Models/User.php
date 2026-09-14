<?php

namespace App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    // Used in app.blade.php navbar: @if(Auth::user()->isAdmin())
    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
