<?php

namespace App\Modules\Website\Http\Controllers;

use Illuminate\View\View;

class PageController
{
    /**
     * Display the services page.
     */
    public function services(): View
    {
        return view('website.pages.services');
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        return view('website.pages.about');
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('website.pages.contact');
    }
}