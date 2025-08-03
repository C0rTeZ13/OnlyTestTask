<?php

namespace App\Actions;

use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SearchAvailableCarsAction
{
    public function execute(array $fields): Collection
    {
        /** @var User $user */
        $user = auth()->user();

        $allowedCategories = $user->position->comfort_categories;
        $filterModels = $fields['models'] ?? [];
        $filterCategories = array_intersect($fields['comfort_categories'] ?? [], $allowedCategories);

        $start = Carbon::parse($fields['start_time']);
        $end = Carbon::parse($fields['end_time']);

        $query = Car::query();

        $categories = !empty($filterCategories) ? $filterCategories : $allowedCategories;

        $query->whereIn('comfort_category', $categories);

        if (!empty($filterModels)) {
            $query->whereIn('model', $filterModels);
        }

        $query->whereDoesntHave('trips', function ($q) use ($start, $end) {
            $q->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            });
        });

        return $query->with('driver')->get();
    }
}
