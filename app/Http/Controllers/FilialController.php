<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use Illuminate\Http\Request;

class FilialController extends Controller
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


    public function get_filials(){
        $filials = Filial::all();
        return response()->json($filials);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filial = new Filial();
        $filial->title = $request->title;
        $filial->address = $request->address;
        $filial->save();
        $filials = Filial::all();
        return response()->json($filials);
    }

    /**
     * Display the specified resource.
     */
    public function show(Filial $filial)
    {
        $filials = Filial::all();
        return response()->json($filials);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $filial= Filial::query()->where('id',$request->id)->first();
        $filial->title = $request->title;
        $filial->address = $request->address;
        $filial->update();
        $filials = Filial::all();
        return response()->json($filials);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filial $filial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
           $filial =  Filial::query()->where('id',$id)->first();
           $filial->delete();
           return redirect()->back();
    }
}
