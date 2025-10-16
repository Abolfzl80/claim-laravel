<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromuser($user);
        return response()->json([
            'message' => 'Register Successfully!',
            'token' => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        try{
            $request->validated();
            $user = User::where('email', $request->email)->firstOrFail();

            if(!$user || !Hash::check($request->password, $user->password)){
                throw ValidationException::withMessages([
                    'ERROR' => 'Invalid Email or Password!',
                ]);
            }
            $token = JWTAuth::fromuser($user);
            return response()->json([
                'token' => $token
            ]);
        }catch(\Exception $e){
            return response()->josn(['Error' => '404 Not Found!']);
        }
    }

    public function profile(Request $request)
    {
        try{
            $u = $request->user();
            $user = User::findOrFail($u->id);
            return response()->json(['you:' => $user]);
        }catch(\Exception $e){
            return response()->json(['Error' => '404 Not Found!']);
        }
    }
}