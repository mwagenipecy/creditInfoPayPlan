<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(){

        return view('pages.document.dashboard');
    }

    public function addCompany(){

        return  view('pages.document.add-company');
    }

    public function addDocument($id){

            $company=Company::findOrFail($id);
      

        return view('pages.document.add-document',['company'=>$company]);
    }
}
