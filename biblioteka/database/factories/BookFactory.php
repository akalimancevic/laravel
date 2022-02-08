<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => rand(1, 199) * 100,
            'book_image_path' => null,
            'quantity' => rand(3,10),
            'genre_id' => Genre::all()->random()->id,
            'author_id' => Author::all()->random()->id,
        ];
    }
}
