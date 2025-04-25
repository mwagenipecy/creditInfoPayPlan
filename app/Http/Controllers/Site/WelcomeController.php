<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){

        return view('pages.welcome');
    }


    public function showPricing(){

        return view('pages.price');
    }
}
