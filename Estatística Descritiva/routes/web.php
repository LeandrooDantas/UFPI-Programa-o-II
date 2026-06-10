<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/slow-query', function () {
    return view('slow-query');})
        ->name('dashboard');

Route::get('/fast-query', function () {
    return view('fast-query');})
        ->name('dashboard');
