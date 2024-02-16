<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralPageController extends Controller
{
    //

    public function registrationPage(){
        return view('guest.registration');
    }

    public function authorization(){
        return view('guest.auth');
    }

    public function welcome(){
        return view('general.welcome');
    }

    public function catalog_page(){
        return view('user.catalog');
    }

    public function info_product_page(){
        return view('user.info_product');
    }

    public function cart_page(){
        return view('user.cart');
    }

    public function order_page_user(){
        return view('user.order');
    }
}
