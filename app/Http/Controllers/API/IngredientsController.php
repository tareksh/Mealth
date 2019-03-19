<?php

namespace App\Http\Controllers\API;

use App\Ingredients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IngredientsController extends Controller
{

    public function index()
    {
        $ingredients =  Ingredients::All();
        return response()->json(['Ingredients' => $ingredients]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Ingredients::create
        ([
            'recipe_id'=>$request['recipe_id'],
            'description'=>$request['description'],
            'raw_material_id'=>$request['raw_material_id'],
            'amount'=>$request['amount']

        ]);
    }

    public function show($id)
    {
        $ingredients =  Ingredients::where('id',$id)->first();
        return response()->json(['Ingredients' => $ingredients]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $update = [];

        if(isset($request['recipe_id']))
        {
            $update['recipe_id'] = $request['recipe_id'];
        }
        if(isset($request['description']))
        {
            $update['description'] = $request['description'];

        }
        if(isset($request['raw_material_id']))
        {
            $update['raw_material_id'] = $request['raw_material_id'];

        }
        if(isset($request['amount']))
        {
            $update['amount'] = $request['amount'];

        }

        Ingredients::where('id',$id)->update
        (
            $update
        );
    }

    public function destroy($id)
    {
        Ingredients::where('id',$id)->delete();
    }
}
