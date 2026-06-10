<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

abstract class Controller
{
    public function slow(): View
    {
        return view('slow-query');
    }

    public function fast(): View
    {
        return view('fast-query');
    }
}
