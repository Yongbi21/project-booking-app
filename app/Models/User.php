<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Team;
use App\Models\RoleUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id')
                    ->withPivot('team_email');
    }

    public function projectRequests()
    {
        return $this->hasMany(ProjectRequest::class);
    }

    public function isAdmin()
    {
        return $this->role->role_name === 'Admin';
    }

    public function isMember()
    {
        return $this->role->role_name === 'Member';
    }

    public function isGuest()
    {
        return $this->role->role_name === 'Guest';
    }




    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
