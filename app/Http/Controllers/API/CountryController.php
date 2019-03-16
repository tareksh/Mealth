<?php

namespace App\Http\Controllers\API;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function GetAllCountry()
    {
        $country =  Country::All();
        return response()->json(['Countries' => $country]);
    }

    public function GetCountry(Request $request)
    {
        $country =  Country::where('id',$request['id'])->first();
        return response()->json(['Country' => $country]);
    }


    public function UpdateCountry(Request $request)
    {
        $country =  Country::where('id',$request['id'])->update
        ([
                'country_name' => $request['country_name'],
                'currency_name'=> $request['currency_name'],
                'currency_symbol'=> $request['currency_symbol'],
                'exchange_rate'=> $request['exchange_rate']
            ]
        );
    }


    public function DeleteCountry(Request $request)
    {
        Country::where('id',$request['id'])->delete();
    }


    public function InsertCountry(Request $request)
    {
        Country::create
        ([
            'country_name'=>$request['country_name'],
            'currency_name'=>$request['currency_name'],
            'currency_symbol'=>$request['currency_symbol'],
            'exchange_rate'=>$request['exchange_rate']

        ]);
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
