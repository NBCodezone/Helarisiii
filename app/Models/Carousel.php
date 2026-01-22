<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'subtitle',
        'image',
        'button_text',
        'button_link',
        'order',
    ];
}
