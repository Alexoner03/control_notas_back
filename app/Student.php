<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function courses(){
        return $this->belongsToMany('App\Course','student_course')->withPivot('nota');
    }

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
}

