<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fast-query', [QueryController::class, 'fast']);

Route::get('/slow-query', [QueryController::class, 'slow']);

Route::get('/benchmark', [QueryController::class, 'benchmark']);
