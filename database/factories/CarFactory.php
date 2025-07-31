<?php

namespace Database\Factories;

use App\Enums\ComfortCategoryEnum;
use App\Models\Car;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'model' => $this->faker->name,
            'driver_id' => $this->faker->optional(0.7)->passthrough(
                Driver::factory()->create()->id
            ),
            'comfort_category' => $this->faker->randomElement(ComfortCategoryEnum::cases())->value,

            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }

    public function withComfortCategory(ComfortCategoryEnum $category): self
    {
        return $this->state([
            'comfort_category' => $category->value,
        ]);
    }

    public function withDriver(int|Driver $driver): self
    {
        return $this->state([
            'driver_id' => $driver instanceof Driver ? $driver->id : $driver,
        ]);
    }

    public function withoutDriver(): self
    {
        return $this->state([
            'driver_id' => null,
        ]);
    }
}
