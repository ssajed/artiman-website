<?php

namespace App\Modules\Identity\Http\Controllers\Admin;

use Illuminate\View\View;

class DashboardController
{
    public function index(): View
    {
        return view('identity.admin.dashboard');
    }
}