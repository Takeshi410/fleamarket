<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'username' => $this->faker->userName(),
        'email' => $this->faker->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'postcode' => sprintf('%07d', $this->faker->numberBetween(0, 9999999)),
        'address' => $this->faker->prefecture() . $this->faker->city() . $this->faker->streetAddress(),
        'building' => $this->faker->secondaryAddress(),
        'avatar_path' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
