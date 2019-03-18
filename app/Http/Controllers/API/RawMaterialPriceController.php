<?php

namespace App\Http\Controllers\API;

use App\RawMaterialPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RawMaterialPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $RawMaterialPrice =  RawMaterialPrice::All();
        return response()->json(['RawMaterialPrice' => $RawMaterialPrice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RawMaterialPrice::create
        ([
            'raw_material_id'=>$request['raw_material_id'],
            'country_id'=>$request['country_id'],
            'price'=>$request['price']

        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $RawMaterial =  RawMaterialPrice::where('id',$id)->first();
        return response()->json(['RawMaterial' => $RawMaterial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        RawMaterialPrice::where('id',$id)->update
        ([
            'raw_material_id'=>$request['raw_material_id'],
            'country_id'=>$request['country_id'],
            'price'=>$request['price']

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RawMaterialPrice::where('id',$id)->delete();

    }
}
