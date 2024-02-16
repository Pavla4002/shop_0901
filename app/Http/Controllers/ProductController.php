<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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

    public function add_reviews(Request $request){
        $review = new Review();
        $review->product_id = $request->id;
        $review->user_id = Auth::id();
        $review->positive = $request->positive;
        $review->negative = $request->negative;
        $review->text = $request->text;
        $review->save();
        $reviews = Review::with('user')->where('product_id',$request->id)->get();
        return response()->json($reviews);
    }

    public function get_need_product(Request $request){
      $product = Product::with('product_filial_sizes.filial',
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
      )->where('id',$request->id_product)->first();
      return response()->json($product);
    }

    public function get_top_products(){ //ТОПОВЫ ПРОДУКТЫ
        $products_top = Product::orderBy('top','desc')->take(4)->get();
        return response()->json($products_top);
    }


    public function get_products(){ //НОВЫЕ ПРОДУКТЫ
        $products = Product::query()->latest('updated_at')->take(4)->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        if ($request->file('images')){
            $count = 0;
            foreach ($request->file('images') as $file){
                $count+=1;
                $path = $file->store('public/img');
                if ($count===count($request->file('images'))){
                    $product->images .='/storage/'.$path;
                }else{
                    $product->images .= '/storage/'.$path.';';
                }
            }
        }

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->type_id = $request->select_type;
        $product->material_id = $request->select_material;
        if ($request->select_stone){
            $product->stone_id = $request->select_stone;
        }else{
            $product->stone_id = null;
        }
        if ($request->select_cutting){
            $product->cutting_id = $request->select_cutting;
        }else{
            $product->cutting_id = null;
        }
        if ( $request->subtype){
            $product->subtype_id = $request->subtype;
        }else{
            $product->subtype_id = null;
        }
        $product->whome_id = $request->select_whome;
        $product->brand_id = $request->select_brand;
        $product->sample_id = $request->select_sample;
        $product->save();
        return response()->json([
            'product_id'=>$product->id,
            'message'=>'Все ок!'],200);
        }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        Product::query()->where('id',$id)->delete();
        return redirect()->back();
    }
}
