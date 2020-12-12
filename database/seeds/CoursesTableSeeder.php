<?php

use App\Course;
use App\Teacher;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = Teacher::all();
        $index = 1;
        foreach ($teachers as $teacher) {
            $course = new Course();
            $course->nombre = "CURSO PROG {$index}";
            $course->inicio = "2020-01-01";
            $course->fin = "2020-02-01";
            $teacher->courses()->save($course);
            $course = new Course();
            $course->nombre = "CURSO TEO {$index}";
            $course->inicio = "2020-01-01";
            $course->fin = "2020-02-01";
            $teacher->courses()->save($course);
            $index++;
        }
    }
}
