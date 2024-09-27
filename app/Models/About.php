<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'section1_title',
        'section1_subtitle',
        'section1_description',
        'section1_button_text',
        'section1_button_link',
        'section1_image',

        'section2_title',
        'section2_subtitle',
        'section2_description',
        'section2_button_text',
        'section2_button_link',
        'section2_image',

    ];
}
