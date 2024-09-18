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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Categoria::factory(5)->create();
        Mercancia::factory(20)->create();
        $mercancias = Mercancia::all();
        $categorias = Categoria::all();
        foreach ($mercancias as $mercancia) {
            $mercancia->categorias()->attach($categorias->random(rand(2,4)));
        }
    }
}
