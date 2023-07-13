<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $user = User::latest()->paginate($perPage);

        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validatedUser = $request->validate([
    //         'first_name' => 'required|alpha',
    //         'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
    //         'last_name' => 'required|alpha',
    //         'contact_number' => 'required|max:20',
    //         'email' => 'required|email|unique:users|max:255',
    //         'password' => 'required|min:8'
    //     ]);

    //     $role = Role::where('role_name', 'guest')->first();
    //     $validatedUser['role_id'] = $role ? $role->id : null;


    //     $validatedUser = array_map('trim', $validatedUser);
    //     $validatedUser['first_name'] = ucwords(strtolower($validatedUser['first_name']));
    //     $validatedUser['last_name'] = ucwords(strtolower($validatedUser['last_name']));

    //     if (isset($validatedUser['middle_name'])) {
    //         $validatedUser['middle_name'] = ucwords(strtolower($validatedUser['middle_name']));
    //     }

    //     $validatedUser['password'] = Hash::make($validatedUser['password']);


    //     $user = User::create($validatedUser);


    //     return response()->json(['user' => $user], 201);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while showing user details. Please try again later.',
                'error' => $e->getMessage()
            ], 400);
        }

    }



    public function update(UpdateUserRequest $request, $id)
    {
        try {
            // Check if the user is authenticated
            if (!$request->user()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'You must be logged in to update user details'
                ], 401);
            }

            // Check if the authenticated user is the owner of the profile
            if ($id != $request->user()->id) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'You are not authorized to update this user\'s details'
                ], 403);
            }

            // Update user details
            $user = User::findOrFail($id);
            $user->first_name = $request->input('first_name');
            $user->middle_name = $request->input('middle_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->contact_number = $request->input('contact_number');
            $user->save();

            return response()->json('User details updated', 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'An error occurred while updating user details. Please try again later.'
            ], 400);
        }
    }










    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, User $user)
    // {
    //     $validatedUser = $request->validate([
    //         "first_name" => "required|max:255",
    //         'middle_name' => ['nullable', 'max:2', 'regex:/^[A-Za-z](\.?)$/'],
    //         "last_name" => "required|max:255",
    //         "contact_number" => "required|max:20|nullable",
    //         "email" => "required|email|unique:users,email|max:255",
    //         "password" => "required|min:8|max:255"
    //     ]);

    //     $validatedUser['role_id'] = Role::where('role_name', 'guest')->value('id');

    //     $validatedUser = array_map('trim', $validatedUser);
    //     $validatedUser['first_name'] = ucwords(strtolower($validatedUser['first_name']));
    //     $validatedUser['last_name'] = ucwords(strtolower($validatedUser['last_name']));

    //     if (isset($validatedUser['middle_name'])) {
    //         $validatedUser['middle_name'] = ucwords(strtolower($validatedUser['middle_name']));
    //     }

    //     $validatedUser['password'] = Hash::make($validatedUser['password']);

    //     $user->update($validatedUser);

    //     return response()->json($user, 200);

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
//     public function destroy(User $user)
//     {
//         $user->delete();

//         // return response()->json("Successfully Deleted!!!");

//         return response()->json(null, 204);
//     }
 }
