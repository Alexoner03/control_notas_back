<?php

namespace App\Http\Controllers;

use App\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return response()->json($roles);
    }
}
