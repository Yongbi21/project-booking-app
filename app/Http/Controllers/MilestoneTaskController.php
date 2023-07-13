<?php

namespace App\Http\Controllers;

use App\Models\MilestoneTask;
use Illuminate\Http\Request;

class MilestoneTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $milestone_task = MilestoneTask::latest()->paginate($perPage);

        return response()->json($milestone_task, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validateMilestoneTask = $request->validate([
            'milestone_id' => [
                 'required', 'exists:milestones,id',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = MilestoneTask::where('milestone_id', $value)
                        ->where('task_id', $request->input('task_id'))
                        ->exists();

                if ($exists) {
                    $fail('The combination of milestone and task already exists.');
                    }
                }
            ],
            'task_id' => 'required','exists:tasks,id',
        ]);

        $milestone_task = MilestoneTask::create($validateMilestoneTask);

        return response()->json(['milestone_task' => $milestone_task], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MilestoneTask  $milestoneTask
     * @return \Illuminate\Http\Response
     */
    public function show(MilestoneTask $milestone_task)
    {

        return response()->json(['milestone_task' => $milestone_task], 201);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Milestone_Task  $milestoneTask
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MilestoneTask  $milestoneTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MilestoneTask $milestone_task)
    {
        $validatedData = $request->validate([
            'milestone_id' => [
                'required', 'exists:milestones,id',
                function ($attribute, $value, $fail) use ($request, $milestone_task) {
                    $exists = MilestoneTask::where('milestone_id', $value)
                        ->where('task_id', $request->input('task_id'))
                        ->where('id', '!=', $milestone_task->id)
                        ->exists();

                    if ($exists) {
                        $fail('The combination of milestone and task already exists.');
                    }
                }
            ],
            'task_id' => 'required|exists:tasks,id',
        ]);

        $milestone_task->update($validatedData);

        return response()->json(['milestone_task' => $milestone_task], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MilestoneTask  $milestoneTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(MilestoneTask $milestoneTask)
    {
        $milestoneTask->delete();

        return response()->json(null, 204);
    }

}
