<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['logement_id', 'reservations_id', 'user_id', 'rating', 'comment'];

    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

    public function reservations() {
        return $this->belongsTo(Reservations::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
