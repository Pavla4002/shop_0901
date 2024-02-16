<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\password;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $user = User::query()->where('id',Auth::id())->first();
//        if($user->password===md5($request->password)){
//            return response()->json(true);
//        }else{
//            return response()->json(false);
//        }
        $filial = Filial::query()->find($request->filial);
        $order = Order::query()->where('user_id',Auth::id())->where('status','создан')->with('filial')->first();
        $order->status='Оформлен';
        $order->filial_id = $filial->id;
        $data_now = date ("d/m/Y");
        $NewDate=Date('d/m/Y', strtotime('+3 days'));
        $order->date_start = $data_now;
        $order->date_end = $NewDate;
        $order->update();
        $carts=[];
        return response()->json($carts);
    }

    /**
     * Display the specified resource.
     */

    public function show(Order $order){
        $orders = Order::query()->where('user_id', Auth::id())->where('status','Оформлен')->with('filial')->get();
        return response()->json($orders);
    }


    public function get_all_orders(){
        $orders = Order::query()->where('status','Оформлен')->with('user','filial','carts')->get();
        return response()->json($orders);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(){
//       $order = Order::query()->where('user_id',Auth::id())->where('status','создан')->first();
//       $order->status='Оформлен';
//       $order->update();
//       $carts=[];
//       return response()->json($carts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
