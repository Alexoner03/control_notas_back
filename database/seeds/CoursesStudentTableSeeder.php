<?php

use App\User;
use Illuminate\Database\Seeder;

class CoursesStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role_id',3)->get();
        $count = 1;
        foreach ($users as $student) {
            $student->student->courses()->attach($count);
            if($count == 20) $count = 1;
            $count++;
        }
    }
}
