<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\updateprofileUser;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\profileResource;

class AuthController extends Controller
{
/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register new user",
 *     description="Sign up new users",
 *     operationId="RegisterUsers",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(property="name", type="string", example="Ali"),
 *             @OA\Property(property="email", type="string", format="email", example="ali@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678"),
 *             @OA\Property(property="password_confirmation", type="string", format="password_confirmation", example="12345678")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful registration"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request"
 *     )
 * )
 */
    public function register(RegisterRequest $request)
    {
        $request->validated();
        $user = User::create([
            'username' => $request->username,
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

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="login user",
 *     description="Sign in user",
 *     operationId="LoginUsers",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="ali@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="12345678")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request"
 *     )
 * )
 */
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

/**
 * @OA\Get(
 *     path="/api/profile",
 *     summary="profile user",
 *     description="see profile user",
 *     tags={"Users"},
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="Successful login"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request"
 *     )
 * )
 */
    public function profile(Request $request)
    {
        try{
            $u = $request->user();
            $user = User::findOrFail($u->id);
            return new profileResource($user);
            #return response()->json(['you:' => $user]);
        }catch(\Exception $e){
            return response()->json(['Error' => '404 Not Found!']);
        }
    }

/**
 * @OA\Put(
 *     path="/api/profile/editINFO",
 *     summary="Edit profile user",
 *     description="edit profile user",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string", format="username", example="alalisod"),
 *             @OA\Property(property="name", type="string", example="Aliii"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful Edited info!!"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request"
 *     )
 * )
 */
    public function editINFO(updateprofileUser $request)
    {
        try{
            $user = $request->user();
            $u = User::findOrFail($user->id);
            $u->update($request->validated());
            return response()->json(['message' => 'Updated information Successfully!!']);
        }catch(\Exception $e){
            return response()->json(['Error' => "$e"]);
        }
    }
}