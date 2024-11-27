<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Resources\CategoriaResource;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests;
    /**
     * @OA\Get(
     *    path="/api/categorias",
     *    summary="Consultar todas las categorías",
     *    description="Retorna todas las categorías",
     *    tags={"Categoría"},
     *    security={{"bearer_token":{}}},
     *    @OA\Response(
     *       response=200,
     *       description="Operación exitosa",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    )
     * )
     */
    public function index()
    {
        $categorias = Categoria::all();
        return CategoriaResource::collection($categorias);
    }

    /**
     * @OA\Post(
     *    path="/api/categorias",
     *    summary="Crear categoría",
     *    description="Crear una nueva categoría",
     *    tags={"Categoría"},
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *       required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"tipo"},
     *              @OA\Property(property="tipo", type="string", example="Smirnoff"),
     *       )
     * )
     *    ),
     *    @OA\Response(
     *       response=201,
     *       description="Categoría creada",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    )
     * )
     */
    public function store(StoreCategoriaRequest $request)
    {
        $this->authorize('Crear categorias');

        $categoria = Categoria::create($request->all());

        return response()->json(
            new CategoriaResource($categoria),
            Response::HTTP_CREATED // 201 Created
        );
    }

    /**
     * @OA\Get(
     *     path="/api/categorias/{categoria}",
     *     summary="Consultar categoría por ID",
     *     description="Obtiene los detalles de una categoría específica",
     *     tags={"Categoría"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *        name="categoria",
     *        description="ID de la categoría",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Categoría encontrada",
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="Categoría no encontrada",
     *     )
     * )
     */
    public function show(Categoria $categoria)
    {
        $this->authorize('Ver categorias');
        return new CategoriaResource($categoria);
    }

    /**
     * @OA\Put(
     *    path="/api/categorias/{categoria}",
     *    summary="Actualizar categoría",
     *    description="Actualizar el campo tipo de una categoría",
     *    tags={"Categoría"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="categoria",
     *        description="ID de la categoría",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           required={"tipo"},
     *           @OA\Property(property="tipo", type="string", example="Categoría Actualizada")
     *       )
     *    ),
     *    @OA\Response(
     *       response=202,
     *       description="Categoría actualizada",
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Categoría no encontrada",
     *    )
     * )
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $this->authorize('Editar categorias');
        $this->authorize('update', $categoria);

        // Actualiza solo los datos de la categoría
        $categoria->update($request->only('tipo'));

        return response()->json(
            new CategoriaResource($categoria),
            Response::HTTP_ACCEPTED
        );
    }


    /**
     * @OA\Delete(
     *    path="/api/categorias/{categoria}",
     *    summary="Eliminar categoría",
     *    description="Elimina una categoría específica por su ID",
     *    tags={"Categoría"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="categoria",
     *        description="ID de la categoría",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *    @OA\Response(
     *       response=204,
     *       description="Categoría eliminada con éxito",
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Categoría no encontrada",
     *    )
     * )
     */
    public function destroy(Categoria $categoria)
    {
        $this->authorize('Eliminar categorias');
        $categoria->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content
    }
}
