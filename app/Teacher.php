<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function courses(){
        return $this->hasMany('App\Course');
    }
}
