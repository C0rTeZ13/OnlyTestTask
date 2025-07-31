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

        $query = Car::query()
            ->whereIn('comfort_category', $allowedCategories);

        if (!empty($filterModels)) {
            $query->whereIn('model', $filterModels);
        }

        if (!empty($filterCategories)) {
            $query->whereIn('comfort_category', array_intersect($filterCategories, $allowedCategories));
        }

        $query->whereDoesntHave('trips', function ($q) use ($start, $end) {
            $q->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($sub) use ($start, $end) {
                        $sub->where('start_time', '<', $start)
                            ->where('end_time', '>', $end);
                    });
            });
        });

        return $query->with('driver')->get();
    }
}
