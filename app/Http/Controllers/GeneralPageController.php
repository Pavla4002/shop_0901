<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralPageController extends Controller
{
    //

    public function RegistrationPage(){
        return view('guest.registration');
    }
}
