<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fast-query', [QueryController::class, 'fast']);

Route::get('/slow-query', [QueryController::class, 'slow']);

Route::get('/teste-redis', function () {
    Cache::put('teste', 'Redis funcionando!', 600);

    return Cache::get('teste');
});
