<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bag>
 */
class BagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(6),
            'price' => $this->faker->numberBetween(10, 100),
            'image' => $this->faker->image(public_path('storage/bags_preview'), 640, 480, null, false),
            'count' => $this->faker->randomNumber(5),
        ];
    }
}
