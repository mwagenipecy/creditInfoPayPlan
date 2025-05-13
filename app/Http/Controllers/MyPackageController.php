<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPackageController extends Controller
{
    //

    public function activePackage(){

        return view('pages.my-package.active');
    }


    public function expiredPackage(){

        return view('pages.my-package.expired');
    }

    public function usageHistory(){

        return view('pages.my-package.usage');
    }


}
