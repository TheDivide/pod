<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;



class AuthenticateController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        //$this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function index()
    {
        //

    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6'
        ];
        $input = Input::only(
            'email',
            'password'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json([
                'error' => [
                    'message' => $validator->errors()->all(),
                ]
            ], 422);
        }
        //dd($validator);

        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => [
                    'message' => 'Failed to authenticate because of bad credentials.',
                ]
                    ], 401);
            }

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => [
                'message' => 'User not authorized.',
            ]], 500);
        }

        // if no errors are encountered we can return a JWT and user data

        //get authenticated user
        $user = Auth::id();

        //get roles
        $collection = User::find($user)->roles;

        if ($collection->isEmpty()) {
            return response()->json(['error' => [
                'message' => 'Could not create token',
            ]], 500);
        }else{
            $role=($collection[0]['attributes']['name']);
        }

        $user = Auth::user();
            //dd($user);
        $user_id=$user->id;
        $email=$user->email;
        $first_name=$user->fname;
        $last_name=$user->lname;
        $last_login=$user->last_login;

        return Response::json(
            compact('id','user_id','email','first_name','last_name','last_login','role','token')
            , 200, array(), JSON_PRETTY_PRINT);


    }



    public function logout()
    {
        //execute logout

        JWTAuth::invalidate(JWTAuth::getToken());
        Auth::logout();

        return Response::json([
            'success' => [
                'message' => 'Successful Logout.',
                'data' => [
                ]
            ]
        ], 200);



    }
}
