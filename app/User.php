<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $with = ['student','teacher','role'];

    protected $hidden = [
        'password', 'api_token', 'updated_at','role_id'
    ];

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function student(){
        return $this->hasOne('App\Student');
    }

    public function teacher(){
        return $this->hasOne('App\Teacher');
    }

    public function hasRole(String $role){
        return Str::lower($this->role->descripcion) === $role;
    }

}
