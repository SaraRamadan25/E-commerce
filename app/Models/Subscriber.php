<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'zip_code',
        'country',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
