<?php

namespace App\Http\Controllers\API;

use App\RawMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RawMaterialController extends Controller
{

    public function index()
    {
        $RawMaterial =  RawMaterial::All();
        return response()->json(['Ingredients' => $RawMaterial]);

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        RawMaterial::create
        ([
            'name'=>$request['name']

        ]);
    }


    public function show($id)
    {
        $RawMaterial =  RawMaterial::where('id',$id)->first();
        return response()->json(['RawMaterial' => $RawMaterial]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        RawMaterial::where('id',$id)->update
        ([
            'name'=>$request['name']

        ]);
    }


    public function destroy($id)
    {
        RawMaterial::where('id',$id)->delete();
    }
}
