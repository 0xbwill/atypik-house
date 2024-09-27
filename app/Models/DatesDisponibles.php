<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatesDisponibles extends Model
{
    use HasFactory;

    protected $table = 'dates_disponibles';

    protected $fillable = ['logement_id', 'debut_dispo', 'fin_dispo'];

    // Indiquer à Laravel que ces attributs sont des dates
    protected $dates = ['debut_dispo', 'fin_dispo'];

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }
}
