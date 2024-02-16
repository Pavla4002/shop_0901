<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Material;
use App\Models\Sample;
use App\Models\Size;
use App\Models\Stone;
use App\Models\Subtype;
use App\Models\Type;

use App\Models\Whome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
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
        $valid = Validator::make($request->all(),[
            'title'=>['required', 'unique:types'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),404);
        }

        $type = new Type();
        $type->title = $request->title;
        $type->save();

        if(!empty($request->subtypes)){
            foreach ($request->subtypes as $subtype) {
                if($subtype!==null){
                    $s = new Subtype();
                    $s->type_id = $type->id;
                    $s->title = $subtype;
                    $s->save();
                }
            }
        }

        if(!empty($request->sizes)){
            foreach ($request->sizes as $size) {
                if($size!==null){
                    $s = new Size();
                    $s->type_id = $type->id;
                    $s->number = doubleval($size);
                    $s->save();
                }
            }
        }

        return response()->json('Данные сохранены',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        $types = Type::with(['subtypes','sizes'])->get();
        return response()->json($types);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        switch ($request->name_char){
            case 'type':
                $thing = Type::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
            case 'stone':
                $thing = Stone::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
            case 'cuttings':
                $thing = Cutting::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
            case 'samples':
                $thing = Sample::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
            case 'whomes':
                $thing = Whome::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
            case 'materials':
                $thing = Material::query()->where('id',$request->char_id)->first();
                $thing->title = $request->title;
                $thing->update();
                break;
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $type)
    {

        switch ($type){
            case 'type':
                $thing = Type::query()->where('id',$id)->delete();
                break;
            case 'stone':
                $thing = Stone::query()->where('id',$id)->delete();
                break;
            case 'cuttings':
                $thing = Cutting::query()->where('id',$id)->delete();
                break;
            case 'samples':
                $thing = Sample::query()->where('id',$id)->delete();
                break;
            case 'whomes':
                $thing = Whome::query()->where('id',$id)->delete();
                break;
            case 'materials':
                $thing = Material::query()->where('id',$id)->delete();
                break;
        }
        return redirect()->back();
    }
}
