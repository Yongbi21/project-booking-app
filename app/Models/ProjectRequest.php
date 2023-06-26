<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRequest extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'budget',
        'priority',
        'due_date',
        'file',
        'project_complexity',
        'estimate_time',
        'additional_services',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUserEmailAttribute()
    {
        return $this->user->email;
    }

    public function getProjectDetailsAttribute()
    {
        return $this->project->toArray();
    }
}

