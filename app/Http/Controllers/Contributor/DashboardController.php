<?php

namespace App\Http\Controllers\Contributor;

class DashboardController
{
    /**
     * Show dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contributor.index');
    }
}
