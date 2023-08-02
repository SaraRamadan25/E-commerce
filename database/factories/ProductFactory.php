<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description'=> $this->faker->text,
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'color' => $this->faker->randomElement(['red', 'blue', 'green']),
            'original_price' => $this->faker->randomNumber(3,10000),
            'price_after_offer' => $this->faker->randomNumber(3,10000),
            'category_id' => Category::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'offer_id' => Offer::factory(),
            'cart_id' => Cart::factory(),
            'rate'=>$this->faker->numberBetween(1,5),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
