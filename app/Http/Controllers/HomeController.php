<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Quizes = Quiz::whereNull('parent_id')->get();
        return view('home', compact('Quizes'));
    }
}
