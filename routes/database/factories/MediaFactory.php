<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'medially_id' => $this->faker->randomNumber(),
            'medially_type' => $this->faker->randomElement(['App\Models\Business', 'App\Models\Invitee', 'App\Models\Biller', 'App\Models\BusinessCategory']),
            'file_url' => $this->faker->imageUrl(),
            'file_name' => $this->faker->name,
            'file_type' => $this->faker->randomElement(['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml']),
            'size' => $this->faker->randomNumber(),
        ];
    }
}
