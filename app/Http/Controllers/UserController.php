<?php

namespace App\Http\Controllers;

use App\Role;
use App\Student;
use App\Teacher;
use App\User;
use Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(){
        $fields = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::whereEmail($fields['email'])->first();

        if(!is_null($user) && $user->role_id !== 1 && $user->state && Hash::check($fields['password'], $user->password))
        {
            $user->api_token = Str::random(200);
            $user->save();

            return response()->json([
                'res' => true,
                'message' => 'Bienvenido al sistema',
                'token' => $user->api_token
            ]);
        }else{
            return response()->json([
                'res' => false,
                'message' => 'Credenciales Incorrectas'
            ],401);
        }
    }

    public function loginAdm(){
        $fields = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::whereEmail($fields['email'])->first();

        if(!is_null($user) && $user->role_id === 1  && $user->state && Hash::check($fields['password'], $user->password))
        {
            $user->api_token = Str::random(200);
            $user->save();

            return response()->json([
                'res' => true,
                'message' => 'Bienvenido al sistema',
                'token' => $user->api_token
            ]);
        }else{
            return response()->json([
                'res' => false,
                'message' => 'Credenciales Incorrectas'
            ],401);
        }
    }

    public function logout(){
        $user = auth()->user();
        $user->api_token = null;
        $user->save();

        return response()->json([
            'res' => true,
            'message' => 'Adios'
        ]);
    }

    public function getAuthenticatedUser(){
        $user =  auth()->user();

        return response()->json([
            'res' => true,
            'message' => '',
            'data' => $user
        ]);

    }

    public function create(String $role){

        $rol = Role::where('descripcion',Str::upper($role))->first();

        if(!$rol){
            return response()->json([
                'res' => false,
                'message' => 'rol no existe'
            ],404);
        }

        $fields = request()->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nombres' => 'string|required',
            'apellidos' => 'string|required',
        ]);

        $fields["role_id"] = $rol->id;
        $fields["password"] = Hash::make($fields["password"]);

        $user = User::create($fields);

        if($rol->id === 2){
            $teacher = new Teacher();
            $teacher->codigo = "profesor-{$user->id}";
            $user->teacher()->save($teacher);
            $user->refresh();
        }else if($rol->id === 3 ){
            $student = new Student();
            $student->codigo = "alumno-{$user->id}";
            $user->student()->save($student);
            $user->refresh();
        }

        return response()->json([
            'res' => true,
            'message' => "usuario {$user->nombres} {$user->apellidos} ha sido creado correctamente  "
        ]);
    }

    public function listByRole(String $role){
        $rol = Role::where('descripcion',Str::upper($role))->first();

        if(!$rol){
            return response()->json([
                "res" => false,
                "message" => "rol no existe",
            ],404);
        }

        $users = User::where('role_id',$rol->id)->where('state',true)->get();

        return response()->json($users);

    }

    public function delete(Int $id){
        $user = User::where('id',$id)->first();

        if(!$user){
            return response()->json([
                "res" => false,
                "message" => "usuario no existente"
            ]);
        }

        $user->state = false;
        $user->save();

        return response()->json([
            "res" => true,
            "message" => "El usuario ha sido dado de baja correctamente"
        ]);

    }

    public function edit(Int $id){

        $fields = request()->validate([
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:8',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
        ]);



        $user = User::where('id',$id)->first();

        if(!$user){
            return response()->json([
                'res' => false,
                'message' => 'usuario no existe'
            ],404);
        }

        if(isset($fields["password"]) && $fields["password"] !== ""){
            $fields["password"] = Hash::make($fields["password"]);
        }else{
            unset($fields["password"]);
        }

        User::where('id',$id)->update($fields);

        $user->refresh();

        return response()->json([
            'res' => true,
            'message' => "usuario {$user->nombres} {$user->apellidos} ha sido editado correctamente"
        ]);
    }
}
