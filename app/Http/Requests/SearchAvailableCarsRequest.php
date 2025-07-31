<?php

namespace App\Http\Requests;

use App\Enums\ComfortCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchAvailableCarsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'models' => ['sometimes', 'array'],
            'models.*' => ['string'],

            'comfort_categories' => ['sometimes', 'array'],
            'comfort_categories.*' => ['integer', Rule::enum(ComfortCategoryEnum::class)],

            'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['required', 'date_format:Y-m-d H:i:s', 'after:start_time'],
        ];
    }
}