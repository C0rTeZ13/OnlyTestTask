<?php

use App\Enums\ComfortCategoryEnum;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Position;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\ComponentTestCase;

uses(ComponentTestCase::class, RefreshDatabase::class);

beforeEach(fn() => Carbon::setTestNow(now()));

afterEach(fn() => Carbon::setTestNow());

test('POST /cars/search filter by models', function () {
    // Пользователь с доступом ко всем категориям
    $position = Position::factory()->create([
        'comfort_categories' => [
            ComfortCategoryEnum::FIRST->value,
            ComfortCategoryEnum::SECOND->value,
            ComfortCategoryEnum::THIRD->value,
        ],
    ]);
    $user = User::factory()->create(['position_id' => $position->id]);
    $token = auth()->login($user);
    $headers = ['Authorization' => "Bearer $token"];

    // Создаем два автомобиля разных моделей
    $driver1 = Driver::factory()->create();
    $carA = Car::factory()->create([
        'model' => 'Toyota Corolla',
        'comfort_category' => ComfortCategoryEnum::SECOND->value,
        'driver_id' => $driver1->id,
    ]);
    $driver2 = Driver::factory()->create();
    $carB = Car::factory()->create([
        'model' => 'BMW 320i',
        'comfort_category' => ComfortCategoryEnum::SECOND->value,
        'driver_id' => $driver2->id,
    ]);

    $payload = [
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'models' => ['Toyota Corolla'],
    ];

    $this->postJson('/api/cars/search', $payload, $headers)
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['id' => $carA->id])
        ->assertJsonMissing(['id' => $carB->id]);
});

test('POST /cars/search filter by comfort_categories and access', function () {
    // Пользователь с доступом только ко второй и третьей категории
    $position = Position::factory()->create([
        'comfort_categories' => [
            ComfortCategoryEnum::SECOND->value,
            ComfortCategoryEnum::THIRD->value,
        ],
    ]);
    $user = User::factory()->create(['position_id' => $position->id]);
    $token = auth()->login($user);
    $headers = ['Authorization' => "Bearer $token"];

    // Машина 1-й категории (не доступна)
    $driver1 = Driver::factory()->create();
    $car1 = Car::factory()->create([
        'comfort_category' => ComfortCategoryEnum::FIRST->value,
        'driver_id' => $driver1->id,
    ]);
    // Машина 2-й
    $driver2 = Driver::factory()->create();
    $car2 = Car::factory()->create([
        'comfort_category' => ComfortCategoryEnum::SECOND->value,
        'driver_id' => $driver2->id,
    ]);
    // Машина 3-й
    $driver3 = Driver::factory()->create();
    $car3 = Car::factory()->create([
        'comfort_category' => ComfortCategoryEnum::THIRD->value,
        'driver_id' => $driver3->id,
    ]);

    $payload = [
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
        'comfort_categories'=> [ComfortCategoryEnum::THIRD->value],
    ];

    $this->postJson('/api/cars/search', $payload, $headers)
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['id' => $car3->id])
        ->assertJsonMissing(['id' => $car1->id])
        ->assertJsonMissing(['id' => $car2->id]);
});

test('POST /cars/search access in time period', function () {
    $position = Position::factory()->create([
        'comfort_categories' => [ComfortCategoryEnum::SECOND->value],
    ]);
    $user = User::factory()->create(['position_id' => $position->id]);
    $token = auth()->login($user);
    $headers = ['Authorization' => "Bearer $token"];

    $driver = Driver::factory()->create();
    $availableCar = Car::factory()->create([
        'comfort_category' => ComfortCategoryEnum::SECOND->value,
        'driver_id' => $driver->id,
    ]);
    $busyCar = Car::factory()->create([
        'comfort_category' => ComfortCategoryEnum::SECOND->value,
        'driver_id' => $driver->id,
    ]);

    Trip::factory()->create([
        'user_id' => $user->id,
        'car_id' => $busyCar->id,
        'start_time' => now()->addHour(),
        'end_time' => now()->addHours(3),
    ]);

    $payload = [
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
    ];

    $this->postJson('/api/cars/search', $payload, $headers)
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonFragment(['id' => $availableCar->id])
        ->assertJsonMissing(['id' => $busyCar->id]);
});

test('POST /cars/search 401', function () {
    $payload = [
        'start_time' => now()->addHour()->format('Y-m-d H:i:s'),
        'end_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
    ];

    $this->postJson('/api/cars/search', $payload)
        ->assertUnauthorized();
});
