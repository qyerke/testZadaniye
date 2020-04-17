<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'completed', 'status_id', 'deadline'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function statuses()
    {
        return $this->belongsToMany('App\Status', 'status_task');
    }
}
