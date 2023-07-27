<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->name,
            'question' => $this->faker->text,
            'answer' => $this->faker->text,
            'tags' => $this->faker->text,
            'popularity' => $this->faker->boolean,
            'last_asked_date' => $this->faker->date(),
        ];
    }
}
