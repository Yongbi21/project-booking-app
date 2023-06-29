<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::latest()->paginate(10);

        return response()->json(['roles' => $role], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateRole = $request->validate([
            'role_name' => 'required|max:255',

        ]);

        $validateRole['role_name'] = ucwords(strtolower($validateRole['role_name']));
        $role = Role::create($validateRole);
        return response()->json($role, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json($role);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validateRole = $request->validate([
            'role_name' => 'required|max:255',
        ]);

        $validateRole['role_name'] = ucwords(strtolower($validateRole['role_name']));

        $role->update($validateRole);

        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();


        return response()->json(null, 204);

        //return response()->json('Successfully deleted');

    }
}
