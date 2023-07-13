<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $project = Project::latest()->paginate($perPage);

        return response()->json($project, 200);
        // return response()->json(['projects' => $project], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedProject = $request->validate([
            'project_name' => 'required|max:255',
            'project_description' => 'required|max:255',
        ]);

        $validatedProject['project_name'] = ucwords(strtolower($validatedProject['project_name']));
        $project = Project::create($validatedProject);

        return response()->json($project, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, Project $project)
    {
         $validatedData = $request->validate([
             'project_name' => 'required|max:255',
             'project_description' => 'required|max:255',
            ]);

         $project->update($validatedData);

         // Update the associated project request records
         $projectRequests = $project->projectRequests;
         foreach ($projectRequests as $projectRequest) {
             $projectRequest->update([
                 'project_name' => $validatedData['project_name'],
                 'project_description' => $validatedData['project_description'],
                ]);
        }

         return response()->json($project, 200);
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $project->delete();

        /**
         * return response()->json('null', 204);
         */

         return response()->json(null, 204);



    }
}
