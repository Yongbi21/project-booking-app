<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';


    protected $fillable = [
        'role_name'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $existingRole = Role::where('role_name', $role->role_name)->first();
            if ($existingRole) {
                abort(422, 'The Role with the same name already exists.');
            }
        });
    }

}
