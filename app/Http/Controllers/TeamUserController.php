<?php

namespace App\Http\Controllers;

use App\Models\TeamUser;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $team_user = TeamUser::latest()->paginate($perPage);

        return response()->json($team_user, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => [
                'required', 'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = TeamUser::where('user_id', $value)
                    ->where('team_id', $request->input('team_id'))
                    ->exists();

                if ($exists){
                    $fail('The combination of team and user already exists.');
                }


                }
            ],

            'team_id' => 'required', 'exists:teams, id',
        ]);

        $team_user = TeamUser::create($validatedData);

        return response()->json(['team_user' => $team_user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $team_user = TeamUser::findOrFail($id);

        return response()->json(['team_user' => $team_user], 200);
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
        $team_user = TeamUser::findOrFail($id);
        $team_user->update($request->all());

        return response()->json(['team_user' => $team_user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team_user = TeamUser::findOrFail($id);
        $team_user->delete();

        return response()->json(null, 204);
    }
}
