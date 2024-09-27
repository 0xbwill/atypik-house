<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   

class Reservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $fillable = ['logement_id', 'user_id', 'debut_resa', 'fin_resa', 'stripe_transaction_id', 'total_amount', 'payment_status', 'payment_date', 'stripe_token'];

    // Indiquer à Laravel que ces attributs sont des dates
    protected $dates = ['debut_resa', 'fin_resa'];


    public function logement()
    {
        return $this->belongsTo(Logement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avis() {
        return $this->hasMany(Avis::class);
    }
}
