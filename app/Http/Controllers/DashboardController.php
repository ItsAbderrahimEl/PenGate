<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController
{
    public function show()
    {
        return Inertia::render('Dashboard/Show');
    }
}
