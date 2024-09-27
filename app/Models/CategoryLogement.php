<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLogement extends Model
{
    use HasFactory;

    protected $table = 'category_logement';
    protected $fillable = ['name'];

    public function logements()
    {
        return $this->hasMany(Logement::class);
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'category_logement_equipement', 'category_logement_id', 'equipement_id');
    }
}
