<?php

use App\Teacher;
use App\User;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role_id',2)->get();
        $index = 1;
        foreach ($users as $user) {
            $teacher = new Teacher();
            $teacher->codigo = "PROF-{$index}";
            $user->teacher()->save($teacher);
            $index++;
        }
    }
}
