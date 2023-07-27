<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checkout>
 */
class CheckoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'mobile' => $this->faker->phoneNumber(),
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->name(),
            'country' => $this->faker->country(),
            'zip_code' => $this->faker->postcode(),
            'payment_method' => $this->faker->creditCardType(),
            'card_number' => $this->faker->creditCardNumber(),
            'card_exp_month' => $this->faker->creditCardExpirationDate(),
            'card_exp_year' => $this->faker->creditCardExpirationDate(),
            'card_cvv' => $this->faker->creditCardExpirationDate(),

        ];
    }
}
