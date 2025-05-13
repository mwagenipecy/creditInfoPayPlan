<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){


       
        return view('pages.payment.dashboard');
    }


    public function paymentLogs(){
        return view('pages.payment.logs');

    }
}
