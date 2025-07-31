<?php

namespace Database\Seeders;

use App\Enums\ComfortCategoryEnum;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Position;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $positions = [
            'Director' => [ComfortCategoryEnum::FIRST, ComfortCategoryEnum::SECOND, ComfortCategoryEnum::FIRST],
            'Manager' => [ComfortCategoryEnum::SECOND, ComfortCategoryEnum::THIRD],
            'Employee' => [ComfortCategoryEnum::SECOND, ComfortCategoryEnum::THIRD],
            'Consultant' => [ComfortCategoryEnum::THIRD],
            'Intern' => [ComfortCategoryEnum::THIRD],
        ];

        foreach ($positions as $name => $categories) {
            Position::query()->create(['name' => $name, 'comfort_categories' => $categories]);
        }

        User::factory()
            ->count(5)
            ->sequence(
                ['email' => 'director@example.com', 'position_id' => 1],
                ['email' => 'manager@example.com', 'position_id' => 2],
                ['email' => 'employee@example.com', 'position_id' => 3],
                ['email' => 'consultant@example.com', 'position_id' => 4],
                ['email' => 'intern@example.com', 'position_id' => 5],
            )
            ->create(['password' => Hash::make('password')]);

        $cars = Car::factory()->count(4)->create(['comfort_category' => ComfortCategoryEnum::FIRST->value])
            ->merge(Car::factory()->count(3)->create(['comfort_category' => ComfortCategoryEnum::SECOND->value]))
            ->merge(Car::factory()->count(3)->create(['comfort_category' => ComfortCategoryEnum::THIRD->value]));

        $drivers = Driver::factory()->count(8)->create();
        $cars->take(8)->each(function ($car, $index) use ($drivers) {
            $car->update(['driver_id' => $drivers[$index]->id]);
        });

        $tripsData = [
            // Машины First класса (ID 1-4)
            [
                'user_id' => 2, // Manager
                'car_id' => 1,
                'start_time' => '2023-06-10 09:00',
                'end_time' => '2023-06-10 12:00'
            ],
            [
                'user_id' => 1, // Director
                'car_id' => 2,
                'start_time' => '2023-06-11 14:00',
                'end_time' => '2023-06-11 17:00'
            ],
            [
                'user_id' => 1, // Director
                'car_id' => 4,
                'start_time' => '2023-06-18 11:00',
                'end_time' => '2023-06-18 15:00'
            ],
            [
                'user_id' => 2, // Manager
                'car_id' => 3,
                'start_time' => '2023-06-12 10:00',
                'end_time' => '2023-06-12 18:00'
            ],

            // Машины Second класса (ID 5-7)
            [
                'user_id' => 3, // Employee
                'car_id' => 5,
                'start_time' => '2023-06-13 08:00',
                'end_time' => '2023-06-13 10:00'
            ],
            [
                'user_id' => 2, // Manager
                'car_id' => 6,
                'start_time' => '2023-06-14 13:00',
                'end_time' => '2023-06-14 15:00'
            ],
            [
                'user_id' => 4, // Consultant
                'car_id' => 7,
                'start_time' => '2023-06-19 09:00',
                'end_time' => '2023-06-19 12:00'
            ],

            // Машины Third класса (ID 8-10)
            [
                'user_id' => 4, // Consultant
                'car_id' => 8,
                'start_time' => '2023-06-15 09:00',
                'end_time' => '2023-06-15 11:00'
            ],
            [
                'user_id' => 5, // Intern
                'car_id' => 9,
                'start_time' => '2023-06-16 16:00',
                'end_time' => '2023-06-16 18:00'
            ],
            [
                'user_id' => 3, // Employee
                'car_id' => 10,
                'start_time' => '2023-06-17 10:00',
                'end_time' => '2023-06-17 14:00'
            ],
        ];

        foreach ($tripsData as $trip) {
            Trip::query()->create([
                'user_id' => $trip['user_id'],
                'car_id' => $trip['car_id'],
                'start_time' => $trip['start_time'],
                'end_time' => $trip['end_time'],
            ]);
        }
    }
}
