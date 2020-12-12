<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 2;
        for ($i=1; $i < 30; $i++) {
            $user = new User();
            $user->email = "correo{$i}@test.com";
            $user->password = Hash::make('password');
            $user->nombres = "Usuario{$i}";
            $user->apellidos = "Apellidos{$i}";
            $user->role_id = $count;
            $user->save();

            if($count == 3) $count = 1;
            $count++;
        }

        $user = new User();
        $user->email = "administrador@test.com";
        $user->password = Hash::make('password');
        $user->nombres = "Administrador";
        $user->apellidos = "Cibertec";
        $user->role_id = 1;
        $user->save();
    }
}
