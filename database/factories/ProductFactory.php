<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Offer;
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
            'original_price' => $this->faker->randomFloat(2, 0, 1000),
            'price_after_offer' => $this->faker->randomFloat(2, 0, 1000),
            'category_id' => Category::factory(),
            'offer_id' => Offer::factory(),
            'checkout_id' => Checkout::factory(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
