<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    //
    public function menu_page_admin(){
        return view('admin.menu');
    }
    public function index_admin(){
        return view('admin.index');
    }

    public function filials(){
        return view('admin.filial');
    }

    public function product_index(){
        return view('admin.product');
    }

    public function orders_page(){
        return view('admin.orders');
    }
}
