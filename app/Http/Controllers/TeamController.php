<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $teams = Team::latest()->paginate(10);

        return response()->json(['teams' => $teams], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'team_name' => 'required|max:255',
            'team_details' => 'required',
            'team_leader_id' => 'required|exists:users,id',
        ]);

        $validatedData['team_name'] = ucwords(strtolower($validatedData['team_name']));
        $validatedData['team_details'] = ucwords(strtolower($validatedData['team_details']));
        $team = Team::create($validatedData);
        return response()->json($team, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Team $team): JsonResponse
    {
        return response()->json(['team' => $team], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Team $team): JsonResponse
    {
        $validatedData = $request->validate([
            'team_name' => 'required|max:255',
            'team_details' => 'required',
            'team_leader_id' => 'required|exists:users,id',
        ]);

        $validatedData['team_name'] = ucwords(strtolower($validatedData['team_name']));
        $validatedData['team_details'] = ucwords(strtolower($validatedData['team_details']));
        $team->update($validatedData);

        return response()->json($team, 200);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json(null, 204);
    }

}
