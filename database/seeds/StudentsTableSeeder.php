<?php

use App\Student;
use App\User;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role_id',3)->get();
        $index = 1;
        foreach ($users as $user) {
            $student = new Student();
            $student->codigo = "ALUM-{$index}";
            $user->student()->save($student);
            $index++;
        }
    }
}
