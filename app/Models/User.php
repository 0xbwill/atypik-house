<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Str;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password', 'profile_photo_path', 'slug', 'phone'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    public function hostRequests()
    {
        return $this->belongsTo(HostRequest::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservations::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            if (!$this->hasRole('admin')) {
                return false;
            }
            return true;
        }
    }

    // Mutator pour créer le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = static::generateUniqueSlug($user->name);
        });

        static::updating(function ($user) {
            $user->slug = static::generateUniqueSlug($user->name, $user->id);
        });
    }

    protected static function generateUniqueSlug($name, $userId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 2;
        while (static::where('slug', $slug)->when($userId, function ($query, $userId) {
            return $query->where('id', '!=', $userId);
        })->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
