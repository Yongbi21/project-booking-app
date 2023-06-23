<?php

namespace App\Models;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    public function milestone(): BelongsToMany
    {
        return $this->belongsToMany(Milestone::class);
    }

    protected $table = 'tasks';

    protected $fillable = [
        'task_name'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $existingTask = Task::where('task_name', $task->task_name)->first();
            if ($existingTask) {
                abort(422, 'Task name already exists.');
            }
        });
    }

}
