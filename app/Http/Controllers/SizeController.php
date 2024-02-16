<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
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
    public function create(Request $request)
    {
        $size = new Size();
        $size->number = $request->name;
        $size->type_id = $request->id;
        $size->save();
        $sizes = Size::query()->where('type_id',$request->id)->get();
        return response()->json($sizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $size = Size::query()->where('id',$request->id)->first();
        $size->number = +$request->number;
        $size->update();
        $sizes = Size::query()->where('type_id',$request->type_id)->get();
        return response()->json($sizes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size, Request $request)
    {
        //
        $size = Size::query()->where('id',$request->id)->delete();
        $sizes = Size::query()->where('type_id', $request->type)->get();
        return response()->json($sizes);
    }
}
