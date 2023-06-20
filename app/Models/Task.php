<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

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
