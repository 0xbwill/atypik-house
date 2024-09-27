<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HostRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'email', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

}
