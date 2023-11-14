<?php

namespace App\Http\Controllers;

use App\Models\Subtype;
use Illuminate\Http\Request;

class SubtypeController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subtype $subtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $subtype = Subtype::query()->where('id',$request->id)->first();
        $subtype->title = $request->title;
        $subtype->update();
        $subtypes = Subtype::query()->where('type_id',$request->type_id)->get();
//        return response()->json('Данные сохранены',200);
        return response()->json($subtypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtype $subtype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtype $subtype, Request $request)
    {
        $subtype = Subtype::query()->where('id',$request->id)->delete();
        $subtypes = Subtype::query()->where('type_id',$request->type)->get();
        return response()->json($subtypes);
    }
}
