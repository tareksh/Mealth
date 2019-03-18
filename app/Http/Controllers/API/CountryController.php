<?php

namespace App\Http\Controllers\API;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{

    public function index()
    {
        $country =  Country::All();
        return response()->json(['Countries' => $country]);
    }

    public function show($id)
    {
        $country =  Country::where('id',$id)->first();
        return response()->json(['Country' => $country]);
    }

    public function destroy($id)
    {
        Country::where('id',$id)->delete();

    }


    public function update(Request $request, $id)
    {
        Country::where('id',$id)->update
        ([
                'country_name' => $request['country_name'],
                'currency_name'=> $request['currency_name'],
                'currency_symbol'=> $request['currency_symbol'],
                'exchange_rate'=> $request['exchange_rate']
            ]
        );
    }


    public function store(Request $request)
    {
        Country::create
        ([
            'country_name'=>$request['country_name'],
            'currency_name'=>$request['currency_name'],
            'currency_symbol'=>$request['currency_symbol'],
            'exchange_rate'=>$request['exchange_rate']

        ]);
    }
    public function create()
    {

    }

    public function edit($id)
    {
        //
    }

    public function GetAllCountry()
    {
        $country =  Country::select('id','country_name')->get();
        return response()->json(['Country' => $country]);
    }

    public function GetCountry($id)
    {

        $country =  Country::select('id','country_name')->where('id',$id)->first();
        return response()->json(['Country' => $country]);
    }



    public function Country_Filter(Request $request)
    {
        $where = [];


        if(isset($request['country_name']))
        {

            $newCompete =  ['country_name', 'like','%'.$request['country_name'].'%'];
            array_push($where, $newCompete);
        }




        $country =  Country::where($where)->get();
        return response()->json(['Country' => $country]);
    }
}
