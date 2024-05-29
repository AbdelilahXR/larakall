<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
   /**
     * Method login
     * 
     * @param Request $request
     * 
     * Status 200: OK. The standard success code and default option.
     * Status 401: Unauthorized. email or password is incorrect.
     */

     public function login(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|string|min:8|max:255',
         ]);
 
         if ($validator->fails()) {
             return response()->json([
                 'errors' => $validator->errors(),
             ], 422);
         }
 
         $user = User::where('email', $request->email)->with('stores')->first();
 
 
         if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                 'message' => 'The provided credentials are incorrect.',
             ], 401);
         }

         
         if (!$user->hasRole('client')) {
             return response()->json([
                 'message' => 'You are not allowed to login.',
             ], 401);
         }
 
         $token = $user->createToken('auth_token')->plainTextToken;
 
         return response()->json([
             'data' => UserResource::make($user),
             'access_token' => $token,
             'token_type' => 'Bearer',
         ]);
     }
 
 
     /**
      * Method logout
      * 
      * @param Request $request
      * 
      * Status 200: OK. The standard success code and default option.
      * Status 401: Unauthorized. email or password is incorrect.
      */
 
     public function logout(Request $request)
     {
         $request->user()->currentAccessToken()->delete();
 
         return response()->json([
             'message' => 'You have been successfully logged out.',
         ]);
     }
}