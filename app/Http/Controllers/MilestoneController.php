<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $milestone = Milestone::latest()->paginate(10);

        return response()->json(['milestones' => $milestone], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateMilestone = $request->validate([
            "milestone_name" => "required|unique:milestones,milestone_name"
        ]);

        $validateMilestone['milestone_name'] = ucwords(strtolower($validateMilestone['milestone_name']));
        $milestone = Milestone::create($validateMilestone);

        return response()->json($milestone, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function show(Milestone $milestone)
    {
        return response()->json($milestone);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Milestone $milestone)
    {
        $validateMilestone = $request->validate([
            'milestone_name' => "required"
        ]);

        $validateMilestone['milestone_name'] = ucwords(strtolower($validateMilestone['milestone_name']));
        $milestone->update();

        return response()->json($milestone, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        // return response()->json('Successfully Deleted');
        return response()->json(null, 204);
    }
}
