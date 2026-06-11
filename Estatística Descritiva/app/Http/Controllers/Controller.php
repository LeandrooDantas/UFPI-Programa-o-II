<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

abstract class Controller
{
    public function slow(): View
    {
        return view('slow-query', [
            'products' => Product::all(),
        ]);
    }

    public function fast(): View
    {
        return view('fast-query');
    }
}
