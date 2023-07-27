<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['price','total_price','quantity','checkout_id','product_id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function checkout(): hasOne
    {
        return $this->hasOne(Checkout::class);
    }
}
