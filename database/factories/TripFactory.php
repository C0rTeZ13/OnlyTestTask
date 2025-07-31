<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        $startTime = $this->faker->dateTime();
        $endTime = $startTime->add(new DateInterval('PT' . $this->faker->numberBetween(30, 60) . 'M'));

        return [
            'car_id' => Car::factory(),
            'user_id' => User::factory(),

            'start_time' => $startTime,
            'end_time' => $endTime,

            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
