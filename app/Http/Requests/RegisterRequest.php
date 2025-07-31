<?php

namespace App\Http\Requests;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'password' => ['required', 'min:6'],
            'position_id' => ['required', Rule::exists(Position::class, 'id')],
        ];
    }
}
