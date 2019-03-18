<?php

namespace App\Http\Controllers\API;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function EditImage(Request $request)
    {
        $country =  Slider::where('id',$request['id'])->update
        ([
                'image' => $request['image'],
                'order'=> $request['order']
                ]
        );
    }

    public function DeleteImage(Request $request)
    {
        Slider::where('id',$request['id'])->delete();
    }

    public function InsertImage(Request $request)
    {
        Slider::create
        ([
            'image' => $request['image'],
            'order'=> $request['order']
        ]);
    }

    public function GetAllImage(Request $request)
    {
        $slider = Slider::All();
        return response()->json(['Slider' => $slider]);
    }

    public function GetImage(Request $request)
    {
        $slider =  Slider::where('id',$request['id'])->first();
        return response()->json(['Slider' => $slider]);
    }
}
