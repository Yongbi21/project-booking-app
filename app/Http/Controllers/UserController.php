<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->paginate(10);

        return response()->json(['users' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'first_name' => 'required|alpha',
            'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
            'last_name' => 'required|alpha',
            'contact_number' => 'required|max:20',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8'
        ]);

        $validatedUser['role_id'] = Role::where('name', 'guest')->value('id');

        $validatedUser = array_map('trim', $validatedUser);
        $validatedUser['first_name'] = ucwords(strtolower($validatedUser['first_name']));
        $validatedUser['last_name'] = ucwords(strtolower($validatedUser['last_name']));

        if (isset($validatedUser['middle_name'])) {
            $validatedUser['middle_name'] = ucwords(strtolower($validatedUser['middle_name']));
        }

        $validatedUser['password'] = Hash::make($validatedUser['password']);


        $user = User::create($validatedUser);
        return response()->json(['user' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedUser = $request->validate([
            "first_name" => "required|max:255",
            'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
            "last_name" => "required|max:255",
            "contact_number" => "required|max:20|nullable",
            "email" => "required|email|unique:users,email|max:255",
            "password" => "required|min:8|max:255"
        ]);

        $validatedUser['role_id'] = Role::where('name', 'guest')->value('id');

        $validatedUser = array_map('trim', $validatedUser);
        $validatedUser['first_name'] = ucwords(strtolower($validatedUser['first_name']));
        $validatedUser['last_name'] = ucwords(strtolower($validatedUser['last_name']));

        if (isset($validatedUser['middle_name'])) {
            $validatedUser['middle_name'] = ucwords(strtolower($validatedUser['middle_name']));
        }

        $validatedUser['password'] = Hash::make($validatedUser['password']);

        $user->update($validatedUser);

        return response()->json($user, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        // return response()->json("Successfully Deleted!!!");

        return response()->json(null, 204);
    }
}
