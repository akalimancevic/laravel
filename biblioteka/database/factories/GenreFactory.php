<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'genre_name' => $this->faker->word(),
            'genre_description' => $this->faker->paragraph(2)
        ];
    }
}
