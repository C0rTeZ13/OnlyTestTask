<?php

namespace App\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(array $credentials): string
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException();
        }

        return $token;
    }
}
