<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Validator;
class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){

        if(!Auth::attempt(['email' => $request['email'], 'password' =>  $request['password']]))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = Auth::user();
        $token = $user->createToken('LPAC')-> accessToken;
        return response()->json(['$token' => $token], $this-> successStatus);
    }

    public function register(Request $request)
    {

        $user = new User();
        $user->email = $request['email'];
        $user->name = $request['name'];
        $user->password = Hash::make($request['password']) ;
        $user->role = $request['role'];
        $user->phone_number = $request['phone_number'];
        $user->country_id = $request['country_id'];
        $user->image = $request['image'];
        $user->save();
        // And created user until here.

        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $request['email'],
            'password'      => $request['password'],
            'scope'         => null,
        ]);

        // Fire off the internal request.
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }

    public function details (Request $request)
    {
        print_r($request->user());
    }

    public function UserActivate(Request $request)
    {

        $user =  User::where('id',$request['id'])->update
        ([
            'active' => $request['active'],

         ]);

    }

    public function UserFilter(Request $request)
    {
        $where = [];

        if(isset($request['role']) )
        {
                $newCompete =   ['role', '=', $request['role']];
                array_push($where, $newCompete);
        }

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


        $user =  User::where($where)->get();
        return response()->json(['User' => $user]);
    }

    public function EditMyProfile(Request $request)
    {

        $user = $request->user();
        User::where('id',$user->id)->update
        ([
            'email'=>$request['email'],
            'name'=>$request['name'],
            'password'=>Hash::make($request['password']),
            'description'=>$request['description'],
            'phone_number'=>$request['phone_number'],
            'country_id'=>$request['country_id'],
            'image'=>$request['image'],

        ]);
    }

    public function EditMyProfileImage(Request $request)
    {

        $user = $request->user();
        User::where('id',$user->id)->update
        ([
            'image'=>$request['image'],
        ]);
    }

    public function GetMyProfile(Request $request)
    {

        $user = $request->user();
        $select =[
            'email',
            'name',
            'description',
            'phone_number',
            'country_name',
            'image'
        ];
        $user =  User::join('countries', 'countries.id', '=', 'users.country_id')->select($select)->where('users.id','=',$user->id)->get();
        return response()->json(['User' => $user]);

    }

    public function test()
    {
        $query= User::first()->country;
        print($query);
    }





}