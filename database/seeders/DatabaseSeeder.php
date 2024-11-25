<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Mercancia;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(RolSeeder::class);
        User::factory()->create([
            'name' => 'Alexis Flores',
            'email' => 'alex@admin.com',
       ])->assignRole('Administrador');
        User::factory()->create([
            'name' => 'Kyrie Irving',
            'email' => 'kyrie@gmail.com',
        ])->assignRole('Editor');
        User::factory()->create([
            'name' => 'Damian Lillard',
            'email' => 'damian@gmail.com',
        ])->assignRole('Usuario');

        User::factory(29)->create()->each(function ($user) {
            $user->assignRole('Usuario');
        });
        Categoria::factory(10)->create();
        Mercancia::factory(20)->create();
        $mercancias = Mercancia::all();
        $categorias = Categoria::all();
        foreach ($mercancias as $mercancia) {
            $mercancia->categorias()->attach($categorias->random(rand(2,4)));
        }
    }
}
