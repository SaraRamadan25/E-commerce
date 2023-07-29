<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_number' => $this->faker->creditCardNumber(),
            'card_exp_month' => $this->faker->creditCardExpirationDate(),
            'card_exp_year' => $this->faker->creditCardExpirationDate(),
            'card_cvv' => $this->faker->creditCardExpirationDate(),
        ];
    }
}
