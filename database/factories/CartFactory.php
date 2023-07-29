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
            'single_item_price'=> $this->faker->randomNumber(4),
            'total_price' => $this->faker->randomNumber(4),
            'quantity' => $this->faker->randomNumber(4),
            'user_id' => User::factory(),
            'checkout_id' => Checkout::factory(),

        ];
    }
}
