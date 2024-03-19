<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'area_id' => Area::factory(),
            'genre_id' => Genre::factory(),
            'name' => $this->faker->unique()->word(),
            'image_url' => $this->faker->imageUrl(),
            'detail' => $this->faker->text(),
        ];
    }
}
