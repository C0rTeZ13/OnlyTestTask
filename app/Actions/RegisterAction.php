<?php

namespace App\Actions;

use App\Models\User;

class RegisterAction
{
    public function execute(array $credentials): string
    {
        $user = User::query()->create($credentials);
        return auth()->login($user);
    }
}
