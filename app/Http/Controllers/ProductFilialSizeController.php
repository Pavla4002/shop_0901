<?php

namespace App\Http\Controllers;

use App\Models\ProductFilialSize;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductFilialSizeController extends Controller
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

                if(count($request->info) == 0){
                    foreach ($request->product_filial_size as $pfs){
                                $prod_fil_size = new ProductFilialSize();
                                $prod_fil_size->product_id = $request->product_id;
                                $prod_fil_size->filial_id = $pfs['filials'];
                                $prod_fil_size->count = intval($pfs['count']);
                                if ($prod_fil_size->count!==0){
                                    $prod_fil_size->save();
                                }
                        }
                }
                if(count($request->info) == 1){
                    foreach ($request->product_filial_size as $pfs){
                        foreach($pfs['info'] as $key=>$item){
                            $prod_fil_size = new ProductFilialSize();
                            $prod_fil_size->product_id = $request->product_id;
                            $prod_fil_size->filial_id = $pfs['filials'][0];
                            $prod_fil_size->size_id = $item['size'];
                            $prod_fil_size->count = $item['count'];
                            $prod_fil_size->save();
                    }
                }
            }
        return response()->json('Все ок!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductFilialSize $productFilialSize)
    {
        $products = Product::with(
            'product_filial_sizes.filial',
            'product_filial_sizes.size',
            'subtype',
            'material',
            'stone',
            'whome',
            'cutting',
            'brand',
            'sample',
            'type'

        )->get();
        return response()->json($products,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductFilialSize $productFilialSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductFilialSize $productFilialSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductFilialSize $productFilialSize)
    {
        //
    }
}
