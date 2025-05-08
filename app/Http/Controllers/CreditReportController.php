<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditReportController extends Controller
{
    public function index(){

        return view('pages.credit-report.dashboard');
    }
}
