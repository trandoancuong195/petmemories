<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use Hash;
class UserController extends Controller
{
    //
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
    public function register(Request $request){
        $user = $this->user->create([
            'name' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
          ]);
          
          return response()->json([
              'status'=> 200,
              'message'=> 'User created successfully',
              'data'=>$user
          ]);
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status'=> 422,
                'message'=> 'invalid_email_or_password',
            ]);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getUserInfo(Request $request){
        try {
            $user = JWTAuth::toUser($request->token);
            return response()->json(['result' => $user]);
        }catch(JWTExeption $e){
            return response()->json(['failed_to_create_token'], 500);
        }
    }
}
