<?php

use Illuminate\Support\Facades\Route;

Route::get('/api-docs', function () {
    return response()->file(resource_path('views/api-docs.blade.php'));
})->name('api.docs');
