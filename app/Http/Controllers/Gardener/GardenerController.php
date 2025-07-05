<?php

namespace App\Http\Controllers\Gardener;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GardenerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'gardener']); // make sure you have gardener middleware
    // }

    /**
     * Show the gardener dashboard.
     */
    public function dashboard()
    {
        return view('gardener.dashboard');
    }
}
