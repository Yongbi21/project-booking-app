<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_user = RoleUser::latest()->paginate(10);

        return response()->json(['role_user' => $role_user], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateRoleUSer = $request->validate([
            'user_id' => [
                'required', 'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = RoleUser::where('user_id', $value)
                    ->where('role_id', $request->input('role_id'))
                    ->exists();

                if ($exists){
                    $fail('The combination of role and user already exists.');
                }


                }
            ],

            'role_id' => 'required', 'exists:roles, id',
        ]);

        $role_user = RoleUser::create($validateRoleUSer);

        return response()->json(['role_user' => $role_user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role_user = RoleUser::findOrFail($id);

        return response()->json(['role_user' => $role_user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role_user = RoleUser::findOrFail($id);
        $role_user->update($request->all());

        return response()->json(['role_user' => $role_user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role_user = RoleUser::findOrFail($id);
        $role_user->delete();

        // return response()->json('"Successfully deleted!!!"');

        return response()->json(null, 204);
    }
}



