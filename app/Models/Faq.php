<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'question',
        'answer',
        'tage',
        'popularity',
        'last_asked_date'
    ];

}
