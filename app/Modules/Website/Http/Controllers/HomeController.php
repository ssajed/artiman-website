<?php

namespace App\Modules\Website\Http\Controllers;

use Illuminate\View\View;

class HomeController
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        return view('website.pages.home');
    }
}