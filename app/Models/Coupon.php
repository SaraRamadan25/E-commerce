<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'percent_off',
    ];

    public static function findByCode($code): ?Coupon
    {
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->type == 'fixed')
        {
            return $this->value;
        }
        elseif ($this->type == 'percentage')
        {
            return round($this->offer->offer_percentage / 100) * $total;
        }
        else
            return 0;
    }
}
