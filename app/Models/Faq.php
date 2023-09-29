<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'question',
        'tags',
        'popularity',
    ];

    protected $casts = [
        'tags' => 'json',
    ];

}
