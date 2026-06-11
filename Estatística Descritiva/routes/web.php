<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fast-query', [QueryController::class, 'fast'])->name('fast.query');;

Route::get('/slow-query', [QueryController::class, 'slow'])->name('slow.query');

Route::get('/benchmark', [QueryController::class, 'benchmark'])->name('benchmark');
