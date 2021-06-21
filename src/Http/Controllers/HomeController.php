<?php

namespace App\Http\Controllers;
class HomeController extends Controller
{
    /**
     * Home Page
     *
     * @return void
     */
    public function index()
    {
        return view('home');
    }
}
