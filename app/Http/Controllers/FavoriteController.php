<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
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
        $product = Product::query()->where('id', $request->id_product)->with('product_filial_sizes.filial',
        'product_filial_sizes.size',
        'subtype',
        'material',
        'stone',
        'whome',
        'cutting',
        'brand',
        'sample',
        'type',
        'favorites'
    )->first();
        $favorites = Favorite::all();
        $prod=[];
        foreach ($favorites as $fav){
            if($fav->product_id===$product->id && $fav->user_id === Auth::id()){
                $prod=$product;
            }
        }
        if($prod===[]){
            $favorite = new Favorite();
            $favorite->user_id = Auth::id();
            $favorite->product_id = $product->id;
            $favorite->save();
        }
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorites)
    {
        //
    }
}
