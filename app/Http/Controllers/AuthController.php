<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\SignupRequest;


class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'contact_number' => $request->input('contact_number'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))



            ]);

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
            'user' => $user,
            'token' => $token
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
            'error' => $e->getMessage(),
            'message' => 'Something went wrong in AuthController.register'
            ], 400);
        }

    }

    public function login(LoginRequest $request)
    {
        try {


            $user = User::where('email', '=', $request->input('email'))->firstOrFail();

            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('user_token')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Invalid credentials',
                    'message' => 'Authentication failed'
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.login'
            ], 500);
        }
    }



    public function logout(LogoutRequest $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return response()->json('User logged out!', 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in AuthController.logout'
            ]);
        }
    }


    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         // Authentication successful
    //         $user = Auth::user();
    //         return response()->json(['user' => $user], 200);
    //     } else {
    //         // Authentication failed
    //         return response()->json(['message' => 'Invalid Email|Password'], 401);
    //     }
    // }



    // public function logout(Request $request)
    // {
    //     $request->session()->flush();
    //     Auth::logout();
    //     return response()->json(['message' => 'Logged out'], 200);
    // }
}
