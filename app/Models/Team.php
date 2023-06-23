<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'team_details',
        'team_leader_id',
    ];

    /**
     * The users that belong to the Team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->withPivot('team_email');
    }

    /**
     * Get the leader of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $existingTeam = Team::where('team_name', $team->team_name)->first();
            if ($existingTeam) {
                abort(409, 'A team with the same name already exists.');
            }
        });
    }
}
