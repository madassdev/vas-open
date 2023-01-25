<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessDirector>
 */
class BusinessDirectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $table->id();
        // $table->bigInteger('business_id')->unsigned();
        // $table->string('fullname')->nullable();
        // $table->string('address')->nullable();
        // $table->string('lga')->nullable();
        // $table->string('postcode')->nullable();
        // $table->string('city')->nullable();
        // $table->string('state')->nullable();
        // $table->string('country')->nullable();
        // $table->string('bvn')->nullable();
        // $table->string('bvn_dob')->nullable();
        // $table->timestamp('deleted_at')->nullable();
        // $table->timestamp('created_at')->nullable();
        // $table->timestamp('updated_at')->nullable();
        return [
            'business_id' => Business::all()->random()->id,
            'fullname' => $this->faker->name,
            'address' => $this->faker->address,
            'lga' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'bvn' => $this->faker->numberBetween(100000000, 999999999),
            'bvn_dob' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
