<?php

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ComponentTestCase;

uses(ComponentTestCase::class, RefreshDatabase::class);

test('POST /auth/register 200', function () {
    /** @var Position $position */
    $position = Position::factory()->create();

    $this->postJson('/api/auth/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'position_id' => $position->id,
    ])->assertOk()->assertJsonStructure(['token']);
});

test('POST /auth/login 200', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk()->assertJsonStructure(['token']);
});

test('POST /auth/login 401 on wrong credentials', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertUnauthorized();
});

test('GET /auth/user 200 with token', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $token = auth()->login($user);

    $this->getJson('/api/auth/user', [
        'Authorization' => "Bearer $token",
    ])->assertOk()->assertJsonFragment([
        'id' => $user->id,
        'email' => $user->email,
    ]);
});

test('GET /auth/user 401 without token', function () {
    $this->getJson('/api/auth/user')->assertUnauthorized();
});
