<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Administrador => CRUD
           Editor => CRU
           Usuario => R
        */
        $administrador = Role::create(['name' => 'Administrador']);
        $editor = Role::create(['name' => 'Editor']);
        $usuario = Role::create(['name' => 'Usuario']);

        Permission::create(['name' => 'Crear mercancias'])->syncRoles([$administrador, $editor]);
        Permission::create(['name'=> 'Editar mercancias'])->syncRoles([$administrador, $editor]);
        Permission::create(['name'=> 'Eliminar mercancias'])->syncRoles([$administrador]);
        Permission::create(['name'=> 'Ver mercancias'])->syncRoles([$administrador, $editor, $usuario]);
    }
}
