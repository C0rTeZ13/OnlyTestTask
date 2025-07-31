<?php

namespace App\Http\Controllers;

use App\Actions\LoginAction;
use App\Actions\RegisterAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        return response()->json(['token' => $action->execute($request->validated())]);
    }

    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return response()->json(['token' => $action->execute($request->validated())]);
    }

    public function user(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
