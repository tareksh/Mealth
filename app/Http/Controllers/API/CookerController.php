<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class CookerController extends UserController
{

    public function index()
    {
        $cooker =  User::select('id','name')->where(
            [['active','=','1'],['role','=','Cooker']]
        )->get();
        return response()->json(['Cooker' => $cooker]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function BestCooker (Request $request)
    {
        $cooker =  User::join('countries', 'countries.id', '=', 'users.country_id')->where('role','=','Cooker')->orderBy('rating','DESC')->get();
        return response()->json(['Cooker' => $cooker]);
    }

    public function CookerFiler(Request $request)
    {
        $where = [];
        $newCompete =   ['role','=','Cooker'];
        array_push($where, $newCompete);


        if(isset($request['name']))
        {

            $newCompete =  ['name', 'like','%'.$request['name'].'%'];
            array_push($where, $newCompete);
        }

        if(isset($request['rate']) )
        {
            $newCompete =  ['rating', '>=', $request['rate']];
            array_push($where, $newCompete);
        }

        if(isset($request['country_name']) )
        {
            $newCompete =  ['country_name', '=', $request['country_name']];
            array_push($where, $newCompete);
        }
        $cooker =  User::join('countries', 'countries.id', '=', 'users.country_id')->where($where)->get();
        return response()->json(['Cooker' => $cooker]);
    }

    public function CookerRecipe(Request $request)
    {
        $Recipe = Recipe::where('cooker_id','=',$request['cooker_id'])->get();
        return response()->json(['Recipe' => $Recipe]);
    }
}
