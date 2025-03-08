<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Access\UserSwitch;

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
        return view('home');
    }

    public function logoutSwitchUser()
    {
        if ( UserSwitch::isSwitch() ) {
            UserSwitch::logout();
            return redirect()->route( 'platform.main' );
        }

        return redirect()->route( 'index' );
    }
}
