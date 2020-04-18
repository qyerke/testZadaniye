<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'completed', 'status_id', 'deadline'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
