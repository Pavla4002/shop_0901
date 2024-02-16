<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductFilialSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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
//        dd($request->size_id[0]);
        $order = Order::query()->where('status','создан')->where('user_id', Auth::id())->firstOrCreate(['status'=>'создан'],['user_id'=>Auth::id()]);
        $product = Product::query()->where('id',$request->id)->first();
        if(count($request->size_id)>0){
            $max = ProductFilialSize::query()->where('product_id', $request->id)->where('size_id',$request->size_id[0])->max('count');
            $filial_need = ProductFilialSize::query()->where('product_id', $request->id)->where('size_id',$request->size_id[0])->where('count', $max)->first();
            $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$request->id)->where('size_id', $request->size_id[0])->firstOrCreate(['order_id'=>$order->id],['product_id'=>$request->id],['size_id', $request->size_id[0]]);
        }else{
            $max = ProductFilialSize::query()->where('product_id', $request->id)->max('count');
            $filial_need = ProductFilialSize::query()->where('product_id', $request->id)->where('count', $max)->first();
            $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$request->id)->firstOrCreate(['order_id'=>$order->id],['product_id'=>$request->id]);
        }

            if($cart->count==0){
                if(count($request->size_id)>0){
                    $cart->size_id = $request->size_id[0];
                    $cart->filial_id = $filial_need->filial_id;
                }
                $cart->count = 1;
                $cart->price = $product->price;
                $order->sum +=  $product->price;

                $cart->save();
                $order->save();
                $carts = Cart::query()->where('order_id',$order->id)->with('product','size')->get();
                return response()->json(['Товар добавлен в корзину',$carts],200);
            }
            else{
                if($cart->count<$filial_need->count){
                    if(count($request->size_id)>0){
                        $cart->size_id = $request->size_id[0];
                        $cart->filial_id = $filial_need->filial_id;
                    }
                        $cart->count += 1;
                        $cart->price += $product->price;
                        $order->sum += $product->price;

                        $cart->update();
                        $order->update();
                        $carts = Cart::query()->where('order_id',$order->id)->with('product','size')->get();
                        return response()->json(['Товар добавлен в корзину',$carts],200);
                }else{
                    $carts = Cart::query()->where('order_id',$order->id)->with('product','size')->get();
                    return response()->json('Больше нельзя добавить продукт в корзину');
                }
            }
    }

    public function get_products_cart(){
        $order = Order::query()->where('user_id', Auth::id())->where('status','создан')->first();
        $carts = Cart::query()->where('order_id', $order->id)->with('product','size')->get();
        return response()->json($carts);
    }

    public function minus_product(Request $request){
        $product= Product::query()->where('id',$request->id)->first();
        $order = Order::query()->where('user_id', Auth::id())->where('status','создан')->first();
        if(count($request->size_id)>0){
            $cart = Cart::query()->where('order_id', $order->id)->where('size_id',$request->size_id[0])->where('product_id',$request->id)->first();
        }else{
            $cart = Cart::query()->where('order_id', $order->id)->where('product_id',$request->id)->first();
        }

        if($cart->count===1){
            $order->sum-=$cart->price;
            $cart->delete();
            $order->update();

        }else{
            $cart->count-=1;
            $cart->price-=$product->price;
            $order->sum-=$product->price;

            $cart->update();
            $order->update();
        }
        $carts = Cart::query()->where('order_id',$order->id)->with('product','size')->get();
        return response()->json($carts);
    }


    public function delete_cart(Request $request){
        $product= Product::query()->where('id',$request->id)->first();
        $order = Order::query()->where('user_id', Auth::id())->where('status','создан')->first();
        if(count($request->size_id)>0){
            Cart::query()->where('order_id', $order->id)->where('size_id',$request->size_id[0])->where('product_id',$request->id)->first()->delete();
            $order->sum-=$product->price;
            $order->update();
        }else{
            $order->sum-=$product->price;
            Cart::query()->where('order_id', $order->id)->where('product_id',$request->id)->first();
            $order->update();
        }
        $carts = Cart::query()->where('order_id',$order->id)->with('product','size')->get();
        return response()->json($carts);
    }


    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
