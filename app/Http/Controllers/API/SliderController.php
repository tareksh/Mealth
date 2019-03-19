<?php

namespace App\Http\Controllers\API;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function update(Request $request, $id)
    {
        $update = [];

        if(isset($request['image']))
        {
            $update['image'] = $request['image'];
        }
        if(isset($request['order']))
        {
            $update['order'] = $request['order'];

        }
         Slider::where('id','=',$id)->update
        (
            $update
        );
    }

    public function destroy($id)
    {
        Slider::where('id',$id)->delete();
    }

    public function store(Request $request)
    {
        Slider::create
        ([
            'image' => $request['image'],
            'order'=> $request['order']
        ]);
    }

    public function index(Request $request)
    {
        $slider = Slider::All();
        return response()->json(['Slider' => $slider]);
    }

    public function show($id)
    {
        $slider =  Slider::where('id',$id)->first();
        return response()->json(['Slider' => $slider]);
    }
}
