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
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){

        if(!Auth::attempt(['email' => $request['email'], 'password' =>  $request['password']]))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = Auth::user();
        $token = $user->createToken('LPAC')-> accessToken;
        return response()->json(['$token' => $token], $this-> successStatus);
    }
    /*
     *
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = request()->only('email','name','password','role');

        $user = new User();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->password = Hash::make($data['password']) ;
        $user->role = $data['role'];
        $user->save();
        // And created user until here.

        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);

        // Fire off the internal request.
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details (Request $request)
    {
        print_r($request->user());
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
    public function test()
    {
        $query= User::first()->country;
        //$query->country();
        print($query);
    }







}