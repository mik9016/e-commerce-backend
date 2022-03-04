<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween(10, 500),
            'title' => $this->faker->word,
            'description' => $this->faker->realText(),
        ];
    }
}
