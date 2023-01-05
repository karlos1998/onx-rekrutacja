<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Auth\Events\Registered;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Laravel\Sanctum\PersonalAccessToken;


use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    public function emailAvailable(Request $request){
        $request->validate([
            'email'     =>  'required|string|email|unique:users',
        ]);
        // if(User::where('email', $email)->get())
        // {
        //     return response()->noContent();
        // }
        // else
        // {
        //     throw new HttpException(403, 'This email is already in use');
        // }
    }

    public function createAccount(Request $request){
        $post_data = $request->validate([
            'firstname' =>  'required|string',
            'lastname'  =>  'required|string',
            'email'     =>  'required|string|email|unique:users',
            'password'  =>  'required|min:8'
        ]);
    
        $user = User::create([
            'firstname' => $post_data['firstname'],
            'lastname'  => $post_data['lastname'],
            'email'     => $post_data['email'],
            'password'  => Hash::make($post_data['password']),
        ]);

        $user->attachRole('user');
        
        event(new Registered($user));
        
        Auth::login($user);

        //return $user;
        
    }

    
    public function login(Request $request){
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
    
        $user = User::where('email', $request['email'])->firstOrFail();
        
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
        
    }

    public function logout(Request $request) {
        
        var_dump($request->user()->currentAccessToken('authToken'));
        //return $request->bearerToken();
    }

    public function index(Request $request) {
        return new UserResource($request->user());
    }
}