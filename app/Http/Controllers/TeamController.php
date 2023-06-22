<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $team = Team::latest()->paginate(10);

        return response()->json(['teams' => $team], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'team_name' => 'required|max:255',
            'team_details' => 'required',
            'email' => 'nullable|email',

        ]);

        $team = team::create($validateData);
        return response()->json($team, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return response()->json(['team', $team], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $validateData = $request->validate([
            'team_name' => 'required|max:255',
            'team_details' => 'required',
            'email' => 'nullable|email',
        ]);

        $team->update($validateData);

        return response()->json($team, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();

        /*
         * return response()->json('null', 204);
         */

        return response()->json('Successfully deleted');


    }
}
