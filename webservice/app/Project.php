<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'due_date', 'done'
    ];

    public function users(){
        return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')->withPivot('type_user');;
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
