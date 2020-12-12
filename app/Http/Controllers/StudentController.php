<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;

class StudentController extends Controller
{
    public function listMyCourses (Int $id){
        $student = Student::where('id',$id)->with('courses','courses.teacher.user')->get();

        if(!$student){
            return response()->json([
                "res" => false,
                "message" => "estudiante no existe"
            ]);
        }

        return response()->json([
            "res" => true,
            "data" => $student
        ]);

    }

    public function listMyCoursesAvailables (Int $id){

        $courses = Course::whereDoesntHave('students', function($q) use ($id){
            $q->where('student_id', $id);
        })->get();

        return response()->json([
            "res" => true,
            "data" => $courses
        ]);

    }

    public function enroll(){
        $fields = request()->validate([
            'student_id' => 'numeric|required',
            'course_id' => 'numeric|required'
        ]);

        $std = Student::find($fields['student_id']);
        $crs = Course::find($fields['course_id']);

        if(!$std){
            return response()->json([
                "res" => false,
                "message" => "estudiante no existe"
            ]);
        }

        if(!$crs){
            return response()->json([
                "res" => false,
                "message" => "curso no existe"
            ]);
        }

        if($std->courses()->find($crs->id)){
            return response()->json([
                "res" => false,
                "message" => "ya esta registrado"
            ]);
        }

        $std->courses()->attach($fields['course_id']);

        return response()->json([
            "res" => true,
            "message" => "se ha registrado al curso {$crs->nombre}"
        ]);

    }
}
