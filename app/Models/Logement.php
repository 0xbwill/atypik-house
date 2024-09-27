<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Logement extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'logements';

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'capacity',
        'bedrooms',
        'bathrooms',
        'pet_allowed',
        'smoker_allowed',
        'city',
        'country',
        'street',
        'postal_code',
        'user_id',
        'category_id',
        'image_url',
        'published',
    ];

    public function scopePriceMin($query, $minPrice)
    {
        if ($minPrice) {
            return $query->where('price', '>=', $minPrice);
        }
        return $query;
    }

    public function scopePriceMax($query, $maxPrice)
    {
        if ($maxPrice) {
            return $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    public function scopeCapacity($query, $capacity)
    {
        if ($capacity) {
            return $query->where('capacity', '>=', $capacity);
        }
        return $query;
    }

    public function scopeBedrooms($query, $bedrooms)
    {
        if ($bedrooms) {
            return $query->where('bedrooms', '>=', $bedrooms);
        }
        return $query;
    }

    public function scopeBathrooms($query, $bathrooms)
    {
        if ($bathrooms) {
            return $query->where('bathrooms', '>=', $bathrooms);
        }
        return $query;
    }
    
    protected $dates = ['created_at', 'updated_at'];

    public function setImageUrlAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            // Si c'est un fichier uploadé, on le stocke et on récupère le chemin
            $filePath = $value->store('public/images', 'public');
            $this->attributes['image_url'] = $filePath;
        } elseif (is_string($value) && preg_match('/^(http|https):\/\//', $value)) {
            // Si c'est une URL externe (utilisée par les factories), on l'assigne directement
            $this->attributes['image_url'] = $value;
        } elseif (is_string($value) && !preg_match('/^(http|https):\/\//', $value)) {
            // Si c'est un chemin local (déjà stocké), on l'assigne directement
            $this->attributes['image_url'] = $value;
        } elseif ($value === null) {
            // Si la valeur est null, on assigne null au champ image_url
            $this->attributes['image_url'] = null;
        } else {
            // Gérer les autres cas si nécessaire
            throw new \InvalidArgumentException("Type de valeur invalide pour l'attribut image_url.");
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function averageRating()
    {
        return $this->avis()->avg('rating');
    }

    public function datesDispos()
    {
        return $this->hasMany(DatesDisponibles::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservations::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryLogement::class);
    }

    public function categoryLogement()
{
    return $this->belongsTo(CategoryLogement::class, 'category_id');
}

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'logement_equipement', 'logement_id', 'equipement_id');
    }
}
