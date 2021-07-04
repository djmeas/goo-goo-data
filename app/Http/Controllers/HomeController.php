<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('tracker');
    }

    /**
     * Displays the about the developer page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function developer() {
        return view('misc.developer');
    }
}
