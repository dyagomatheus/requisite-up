<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'due_date', 'project_id', 'user_id', 'risk', 'runtime', 'value_client'
    ];

    public function projects(){
        return $this->belongsTo('App\Project');
    }

    public function user(){
        return $this->hasMany('App\User');
    }

    public function getDueDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
