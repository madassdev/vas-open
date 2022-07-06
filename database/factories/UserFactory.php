<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $table->bigInteger('business_id')->unsigned();
        // $table->string('first_name')->nullable();
        // $table->string('last_name')->nullable();
        // $table->string('email')->nullable();
        // $table->string('phone')->nullable();
        // $table->string('password')->nullable();
        // $table->integer('role_id')->nullable();
        // $table->tinyInteger('verified')->nullable();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('verification_code')->nullable();
        // $table->timestamp('created_at')->nullable();
        // $table->timestamp('updated_at')->nullable();
        return [
            'business_id' => $this->faker->randomNumber(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => Hash::make('password'),
            'role_id' => DB::table('roles')->inRandomOrder()->first()->id,
            'verified' => $this->faker->randomElement([0, 1]),
            'email_verified_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'verification_code' => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
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
