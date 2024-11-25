<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\Mercancia;
use App\Models\User;
use App\Models\Categoria;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);
uses(WithFaker::class);

// Prueba para listar mercancias
test('index', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));
    Categoria::factory()->create();
    Mercancia::factory(3)->create();
    $response = $this->getJson('/api/mercancias');
    //dd($response->json());
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'tipo',
                    'atributos' => [
                        'nombre',
                        'precio',
                        'cantidad',
                        'tipo_id',
                    ]
                ]
            ]
        ]);
});

// Prueba para mostrar una mercancia específica
test('show', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));
    $categoria = Categoria::factory()->create();
    $mercancia = Mercancia::factory()->create();
    $response = $this->getJson("/api/mercancias/{$mercancia->id}");
    // dd($response->json());
    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'tipo',
                'atributos' => [
                    'nombre',
                    'precio',
                    'cantidad',
                    'tipo_id',
                ]
            ]
        ]);
});

// Prueba para crear una mercancia
test('store', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    $usuario = Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));
    $categoria = Categoria::factory()->create();
    $data = [
        'nombre' => $this->faker->word,
        'precio' => $this->faker->randomNumber(),
        'cantidad' => $this->faker->numberBetween(1, 100),
        'tipo_id' => $categoria->id,
    ];
    $response = $this->postJson('/api/mercancias/', $data);
    // dd($response->json());
    $response->assertStatus(Response::HTTP_CREATED);
    // Verificar que se haya creado el registro
    $this->assertDatabaseHas('mercancias', ['nombre' => $data['nombre']]);
});
// Prueba para actualizar una mercancia
test('update', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    $usuario = Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));
    $categoria = Categoria::factory()->create();
    $mercancia = Mercancia::factory()->create();
    $data = [
        'nombre' => 'nombre actualizado',
        'precio' => 99,
        'cantidad' => 50,
        'tipo_id' => $categoria->id,
    ];
    $response = $this->putJson("/api/mercancias/{$mercancia->id}", $data);
    // dd($response->json());
    $response->assertStatus(Response::HTTP_ACCEPTED);
    // Verificar que se haya actualizado el registro
    $this->assertDatabaseHas('mercancias', [
        'nombre' => 'nombre actualizado',
        'precio' => 99,
        'cantidad' => 50,
    ]);
});

// Prueba para eliminar una mercancia
test('destroy', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));
    Categoria::factory()->create();
    $mercancia = Mercancia::factory()->create();
    $response = $this->deleteJson("/api/mercancias/{$mercancia->id}");
    $response->assertStatus(Response::HTTP_NO_CONTENT);
    // Verificar que se haya eliminado el registro
    $this->assertDatabaseMissing('mercancias', ['id' => $mercancia->id]);
});

// Prueba para evitar que un rol sin permisos elimine mercancia
test('destroy_editor', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);
    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));
    Categoria::factory()->create();
    $mercancia = Mercancia::factory()->create();
    $response = $this->deleteJson("/api/mercancias/{$mercancia->id}");
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

