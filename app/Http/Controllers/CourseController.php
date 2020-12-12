<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\Teacher;

class CourseController extends Controller
{
    public function create(){
        $fields = request()->validate([
            'nombre' => 'required|string|unique:courses,nombre',
            'inicio' => 'required|date',
            'fin' => 'required|date',
            'teacher_id' => 'numeric|required',
        ]);

        $teacher = Teacher::where('id',$fields["teacher_id"])->first();

        if(!$teacher){
            return response()->json([
                "res" => false,
                "message" => 'docente no existe'
            ]);
        }

        Course::create($fields);

        return response()->json([
            "res" => true,
            "message" => "el curso {$fields['nombre']} ha sido creado correctamente"
        ]);
    }

    public function edit(Int $id){

        $course = Course::where('id',$id)->first();

        if(!$course){
            return response()->json([
                "res" => false,
                "message" => 'curso no existe'
            ]);
        }

        $fields = request()->validate([
            'nombre' => "required|string|unique:courses,nombre,{$id}",
            'inicio' => 'required|date',
            'fin' => 'required|date',
            'teacher_id' => 'numeric|required',
        ]);

        $teacher = Teacher::where('id',$fields["teacher_id"])->first();

        if(!$teacher){
            return response()->json([
                "res" => false,
                "message" => 'docente no existe'
            ]);
        }

        Course::where('id',$id)->update($fields);

        return response()->json([
            "res" => true,
            "message" => "el curso {$fields['nombre']} ha sido editado correctamente"
        ]);
    }

    public function listAll(){
        $courses = Course::where("state",true)->get();
        return response()->json([
            "res" => true,
            "message" => "",
            "data" => $courses
        ]);
    }

    public function listByTeacher(Int $id){
        $teacher = Teacher::where('id',$id)->first();

        if(!$teacher){
            return response()->json([
                "res" => false,
                "message" => 'docente no existe'
            ]);
        }

        $courses = Course::where('teacher_id',$id)->where('state',true)->get();

        return response()->json([
            "res" => true,
            "message" => "",
            "data" => $courses
        ]);
    }

    public function delete(Int $id){
        $course = Course::where('id',$id)->first();

        if(!$course){
            return response()->json([
                "res" => false,
                "message" => 'curso no existe'
            ]);
        }

        $course->state = false;
        $course->save();

        return response()->json([
            "res" => true,
            "message" => "el curso ha sido eliminado correctamente"
        ]);
    }

    public function detail(Int $id)
    {
        $course = Course::where('id',$id)->with('students','students.user','teacher.user')->first();

        if(!$course){
            return response()->json([
                "res" => false,
                "message" => 'curso no existe'
            ]);
        }

        return response()->json($course);

    }

    public function updateCalification(){
        $fields = request()->validate([
            'nota' => 'required|numeric|min:0|max:20',
            'cursoid' => 'required|numeric',
            'studentid' => 'required|numeric',
        ]);

        $std = Student::find($fields['studentid']);

        if(!$std){
            return response()->json([
                "res" => false
            ]);
        }

        $std->courses()->updateExistingPivot($fields['cursoid'],['nota' => $fields['nota']]);

        return response()->json([
            "res" => true
        ]);
    }

}
