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
         // Crear categorías específicas
         $categorias = [
            'Modelo',
            'Victoria',
            'Corona',
        ];
        // Opciones de nombres aleatorios para las mercancías
        $nombresMercancias = [
            'Cerveza de 355ml',
            'Caguama',
            'Six pack',
            'Cerveza lata',
        ];

        foreach ($categorias as $categoriaNombre) {
            $categoria = Categoria::create(['tipo' => $categoriaNombre]);

            // Crear 8 mercancías para cada categoría
            for ($i = 1; $i <= 8; $i++) {
                Mercancia::create([
                    'nombre' => fake()->randomElement($nombresMercancias). " " . $categoria->tipo, // Nombre aleatorio + categoría
                    'precio' => rand(30, 100), // Precio entre 20 y 100
                    'cantidad' => rand(10, 100), // Cantidad entre 10 y 50
                    'tipo_id' => $categoria->id, // ID de la categoría actual
                    'user_id' => rand(1,2), // Puedes cambiar el ID del usuario a uno específico
                ]);
            }
        }
        
    }
}
