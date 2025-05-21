<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function userProfile(){

        return view('pages.setting.profile');
    }

    public function userSettings(){

        return view('pages.setting.setting');
    }
}
