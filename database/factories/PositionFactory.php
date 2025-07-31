<?php

namespace Database\Factories;

use App\Enums\ComfortCategoryEnum;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        $categories = $this->faker->randomElements(ComfortCategoryEnum::cases(), $this->faker->numberBetween(1, count(ComfortCategoryEnum::cases())));

        return [
            'name' => $this->faker->unique()->jobTitle(),
            'comfort_categories' => array_map(fn($enum) => $enum->value, $categories),

            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
