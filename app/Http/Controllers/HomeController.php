<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcomeView()
    {
        return view('public_views.welcome');
    }

    public function homeView()
    {
        return view('public_views.home');
    }

    public function detailDocument()
    {
        return view('public_views.detail_document');
    }
}
