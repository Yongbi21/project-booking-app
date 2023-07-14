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
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $projectRequest = ProjectRequest::latest()->paginate($perPage);

        return response()->json($projectRequest, 200);
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
            'project_name' => 'required|max:255',
            'project_description' => 'required|max:500',
            'budget' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'priority' => 'required',
            'due_date' => 'required|date',
            'file' => 'nullable|file',
        ]);

        $projectRequest = ProjectRequest::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
            'budget' => $validatedData['budget'],
            'priority' => $validatedData['priority'],
            'due_date' => $validatedData['due_date'],
            'file' => null, // Initialize the file path as null
        ]);

        // Handle file upload and update the file path in the project request
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads'); // Set the desired storage path for the file
            $projectRequest->file = $filePath; // Update the file path in the project request
            $projectRequest->save();
        }

        // Create a project record in the projects table
        $project = Project::create([
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
        ]);

        $projectRequest->project()->associate($project);
        $projectRequest->save();

        return response()->json(['projectRequest' => $projectRequest], 201);
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'project_name' => 'required|max:255',
            'project_description' => 'required|max:500',
            'budget' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'priority' => 'required',
            'due_date' => 'required|date',
            'file' => 'nullable|string',
        ]);

        // Find the existing project request by ID
        $projectRequest = ProjectRequest::findOrFail($id);

        // Update the project request with the validated data
        $projectRequest->update($validatedData);

        // Update the associated project record
        $project = $projectRequest->project;
        $project->update([
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
        ]);

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
