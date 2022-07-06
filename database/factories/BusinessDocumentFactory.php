<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessDocument>
 */
class BusinessDocumentFactory extends Factory
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
            'cac_2' => $this->faker->imageUrl(),
            'cac_7' => $this->faker->imageUrl(),
            'certificate' => $this->faker->imageUrl(),
            'company_profile' => $this->faker->imageUrl(),
            'board_resolution' => $this->faker->imageUrl(),
            'memo_article' => $this->faker->imageUrl(),
            'share_allotment' => $this->faker->imageUrl(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),

        ];
    }
}
