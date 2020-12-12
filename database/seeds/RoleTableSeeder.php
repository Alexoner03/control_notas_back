<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['ADMINISTRADOR', 'DOCENTE', 'ALUMNO'];

        foreach ($roles as $item) {
            $rol = new Role();
            $rol->descripcion = $item;
            $rol->save();
        }
    }
}
