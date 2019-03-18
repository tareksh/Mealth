<?php

namespace App\Http\Controllers\API;

use App\RawMaterialPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RawMaterialPriceController extends Controller
{

    public function index()
    {
        $RawMaterialPrice =  RawMaterialPrice::All();
        return response()->json(['RawMaterialPrice' => $RawMaterialPrice]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        RawMaterialPrice::create
        ([
            'raw_material_id'=>$request['raw_material_id'],
            'country_id'=>$request['country_id'],
            'price'=>$request['price']

        ]);

    }

    public function show($id)
    {
        $RawMaterial =  RawMaterialPrice::where('id',$id)->first();
        return response()->json(['RawMaterial' => $RawMaterial]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        RawMaterialPrice::where('id',$id)->update
        ([
            'raw_material_id'=>$request['raw_material_id'],
            'country_id'=>$request['country_id'],
            'price'=>$request['price']

        ]);
    }

    public function destroy($id)
    {
        RawMaterialPrice::where('id',$id)->delete();

    }
}
