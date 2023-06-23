<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The roles that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
                abort(422, 'Role name already exists.');
            }
        });
    }

}
