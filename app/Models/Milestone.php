<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Milestone extends Model
{
    use HasFactory;

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    protected $table = 'milestones';


    protected $fillable = [
        'milestone_name'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($milestone) {
            $existingMilestone = Milestone::where('milestone_name', $milestone->milestone_name)->first();
            if ($existingMilestone) {
                abort(422, 'Milestone name already exists.');
            }
        });
    }

}
