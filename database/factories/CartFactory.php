<?php

namespace Database\Factories;

use App\Models\Checkout;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price'=> $this->faker->randomFloat(2, 0, 1000),
            'total_price' => $this->faker->randomFloat(2, 0, 1000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'product_id' => Product::factory(),
            'checkout_id' => Checkout::factory(),

        ];
    }
}
