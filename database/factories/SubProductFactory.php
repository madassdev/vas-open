<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubProduct>
 */
class SubProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'up_product_key' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
