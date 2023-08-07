<?php

namespace Database\Factories;

use App\Models\Checkout;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          /*  'code' => (string) $this->faker->randomNumber(),
            'type' => $this->faker->randomElement(['fixed', 'percent']),
            'value' => $this->faker->randomNumber(),
            'percent_off' => $this->faker->randomNumber(),*/
        ];
    }
}
