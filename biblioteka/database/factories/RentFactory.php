<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;

class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'book_id' => Book::all()->random()->id,
            'status' => array_rand(array('IZNAJMLJENA', 'VRACENA'))
        ];
    }
}
