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
        $a= \Auth::user()->email;

       if(\Auth::user()->role->value == 3)
       {
        return view('home');
       }
       
       if(\Auth::user()->role->value == 1)
       {
        return view('clientdashboard')->with('id',\Auth::user()->id);
       }
        
    }
}
