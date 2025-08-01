<?php

namespace App\Http\Support\Resources;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmptyResource implements Responsable
{
    /** @param  Request  $request */
    public function toResponse($request): Response
    {
        return response()->json(['data' => null]);
    }
}
