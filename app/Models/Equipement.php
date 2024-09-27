<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    protected $table = 'equipements';

    protected $fillable = ['name'];

    public function logements()
    {
        return $this->belongsToMany(Logement::class, 'logement_equipement', 'equipement_id', 'logement_id');
    }

    public function categoriesLogement()
    {
        return $this->belongsToMany(CategoryLogement::class, 'category_logement_equipement', 'equipement_id', 'category_logement_id');
    }
}
