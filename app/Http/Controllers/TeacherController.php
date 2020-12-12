<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function listAll()
    {
        $teachers = Teacher::with('user')->get();
        return response()->json([
            "res" => true,
            "data" => $teachers
        ]);
    }
}
