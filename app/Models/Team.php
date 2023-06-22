<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;


    protected $table = 'teams';

    protected $fillable = [
        'team_name',
        'team_details',
        'email',
    ];

    /**
     * The users that belong to the Team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $existingTeam = Team::where('team_name', $team->team_name)->first();
            if ($existingTeam) {
                abort(422, 'Team name already exists.');
            }
        });
    }


}
