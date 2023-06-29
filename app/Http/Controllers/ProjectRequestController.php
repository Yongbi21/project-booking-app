<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectRequest;
use Illuminate\Support\Facades\Auth;

class ProjectRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectRequest = ProjectRequest::latest()->paginate(10);

        return response()->json(['projectRequest' => $projectRequest], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'budget' => 'required|numeric',
            'priority' => 'required',
            'due_date' => 'required|date',
            'file' => 'nullable|string',
            'project_complexity' => 'required',
            'estimate_time' => 'required|integer',
            'additional_services' => 'nullable|string',
        ]);

        $projectRequest = ProjectRequest::create($validatedData);

        return response()->json(['projectRequest' => $projectRequest->fresh()], 200);
    }

    public function indexGuestRequest()
    {
        $projectRequest = ProjectRequest::latest()->paginate(10);

        return response()->json(['projectRequest' => $projectRequest], 200);
    }


    public function storeGuestRequest(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id', // Check if the user ID exists in the "users" table
            'project_name' => 'required|max:255',
            'project_description' => 'required|max:500',
            'budget' => 'required|numeric',
            'priority' => 'required',
            'due_date' => 'required|date',
            'file' => 'nullable|string',
            'project_complexity' => 'required',
            'estimate_time' => 'required|integer',
            'additional_services' => 'nullable|string',
        ]);

        // If a user ID is provided, create a project request associated with the user
        $projectRequest = ProjectRequest::create($validatedData);

        // Create a project record in the projects table
        $project = Project::create([
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
        ]);

        $projectRequest->project()->associate($project);
        $projectRequest->save();

        return response()->json(['projectRequest' => $projectRequest], 200);
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectRequest  $projectRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectRequest $projectRequest)
    {
        return response()->json(['projectRequest' => $projectRequest], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectRequest  $projectRequest
     * @return \Illuminate\Http\Response
     */
    // public function edit(ProjectRequest $projectRequest)
    // {
    //     //
    // }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectRequest  $projectRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectRequest $projectRequest)
    {
        $validatedData = $request->validate([
        'project_id' => 'required',
        'user_id' => 'required',
        'budget' => 'required|numeric',
        'priority' => 'required',
        'due_date' => 'required|date',
        'file' => 'nullable|string',
        'project_complexity' => 'required',
        'estimate_time' => 'required|integer',
        'additional_services' => 'nullable|string',
    ]);


        $projectRequest->update($validatedData);

        return response()->json(['projectRequest' => $projectRequest], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectRequest  $projectRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectRequest $projectRequest)
    {
        $projectRequest->delete();

        return response()->json(null, 204);

    }
}
