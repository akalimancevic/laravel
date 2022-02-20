<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

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
            'created_at' => $this->faker->dateTimeInInterval('-120 days', '+120 days'),
            'status' => array('IZNAJMLJENA', 'VRACENA')[rand(0,1)]
        ];
    }
}
