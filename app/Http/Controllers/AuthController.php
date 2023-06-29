<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation and user creation logic similar to the store method in UserController
        $validatedUser = $request->validate([
            'first_name' => 'required|alpha',
            'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
            'last_name' => 'required|alpha',
            'contact_number' => 'required|max:20',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8'
        ]);

        $validatedUser = array_map('trim', $validatedUser);
        $validatedUser['first_name'] = ucwords(strtolower($validatedUser['first_name']));
        $validatedUser['last_name'] = ucwords(strtolower($validatedUser['last_name']));

        if (isset($validatedUser['middle_name'])) {
            $validatedUser['middle_name'] = ucwords(strtolower($validatedUser['middle_name']));
        }

        $validatedUser['password'] = Hash::make($validatedUser['password']);


        $user = User::create($validatedUser);

        // Return a response indicating successful registration
        return response()->json(['message' => 'Registration successful'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            return response()->json(['user' => $user], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid Email|Password'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
