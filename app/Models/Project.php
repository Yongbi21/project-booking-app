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

    static::creating(function ($role_user) {
        $existingRoleUser = RoleUser::where('role_id', $roleUser->role_id)
            ->where('user_id', $roleUser->user_id)
            ->first();

        if ($existingRoleUser) {
            abort(422, 'The role-user combination already exists.');
        }
    });
}

}
