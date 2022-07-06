<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Business;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitee>
 */
class InviteeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_id' => Business::all()->random()->id,
            'email' => $this->faker->email,
            'code' => $this->faker->randomNumber(6),
            'host_user_id' => User::all()->random()->id,
            'role_id' => Role::all()->random()->id,
            'status' => $this->faker->boolean(),
        ];
    }
}
