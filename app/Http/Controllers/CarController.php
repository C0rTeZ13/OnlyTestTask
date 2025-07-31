<?php

namespace App\Http\Controllers;

use App\Actions\SearchAvailableCarsAction;
use App\Http\Requests\SearchAvailableCarsRequest;
use App\Http\Resources\CarsResource;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Routing\Controller;

class CarController extends Controller
{
    public function search(SearchAvailableCarsRequest $request, SearchAvailableCarsAction $action): Responsable
    {
        return CarsResource::collection($action->execute($request->validated()));
    }
}
