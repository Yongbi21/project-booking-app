<?php

namespace App\Models;

use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }



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
