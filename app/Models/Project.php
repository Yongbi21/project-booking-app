<?php

namespace App\Models;

use Exception;
use App\Models\ProjectRequest;
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


    public function projectRequests()
    {
        return $this->hasMany(ProjectRequest::class);
    }

}
