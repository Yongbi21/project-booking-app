<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';


    protected $fillable = [
        'project_name',
        'project_description'
    ];



    public static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $existingProject = Project::where('project_name', $project->project_name)
            ->where('project_description', $project->project_description)
            ->first();
            if ($existingProject) {
                abort(422, 'Project name and description already exists.');
            }
        });
    }

}
