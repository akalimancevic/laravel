<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'created_at' => $this->faker->dateTimeInInterval('-7 days', '+14 days')
        ];
    }
}
