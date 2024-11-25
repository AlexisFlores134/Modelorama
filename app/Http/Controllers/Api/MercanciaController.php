<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mercancia;
use App\Http\Resources\MercanciaResource;
use App\Http\Requests\StoreMercanciasRequest;
use App\Http\Requests\UpdateMercanciasRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MercanciaController extends Controller
{
    use AuthorizesRequests;
        /**
     * @OA\Get(
     *    path="/api/mercancias",
     *    summary="Consultar todas las mercancias",
     *    description="Retorna todas las mercancias",
     *    tags={"Mercancia"},
     *    security={{"bearer_token":{}}},
     *    @OA\Response(
     *       response=200,
     *      description="Operación exitosa",
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="No autorizado"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="No se encontraron mercancias"
     *   ),
     *   @OA\Response(
     *    response=405,
     *    description="Método no permitido"
     *   )
     * )
     */
    public function index(){
        $this->authorize("Ver mercancias");
        $mercancias = Mercancia::with('categorias')->get();
        return MercanciaResource::collection($mercancias);
    }
        /**
     * @OA\Post(
     *    path="/api/mercancias",
     *    summary="Crear mercancia",
     *    description="Crear una nueva mercancia",
     *    tags={"Mercancia"},
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"nombre","precio","cantidad","tipo_id"},
     *              @OA\Property(property="nombre", type="string", example="Cerveza Modelo"),
     *              @OA\Property(property="precio", type="integer", example="35"),
     *              @OA\Property(property="cantidad", type="integer", example="100"),
     *              @OA\Property(property="tipo_id", type="string", example="1"),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=201,
     *       description="Receta creada",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    )
     * )
     */
    public function store(StoreMercanciasRequest $request){
        $this->authorize('Crear mercancias');

        $mercancia=$request->user()->mercancias()->create($request->all());
        $mercancia->categorias()->attach(json_decode($request->categorias));

        return response()->json(
            new MercanciaResource($mercancia),
            Response::HTTP_CREATED
        ); // 201 Created
    }
        /**
     * @OA\Get(
     *     path="/api/mercancias/{mercancia}",
     *     summary="Obtener mercancia por ID",
     *     description="Retorna una mercancia con su id, nombre, precio, cantidad, tipo_id y autor",
     *     tags={"Mercancia"},
     *     security={ {"bearer_token": {} }},
     *     @OA\Parameter(
     *        name="mercancia",
     *        description="ID de la mercancia",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Mercancia",
     *     ),
     *     @OA\Response(
     *        response=403,
     *        description="No autorizado",
     *     )
     * )
     */
    public function show(Mercancia $mercancia){
        $this->authorize('Ver mercancias');
        $mercancia=$mercancia->load('categorias');
        return new MercanciaResource($mercancia);
    }
        /**
     * @OA\Put(
     *    path="/api/mercancias/{mercancia}",
     *    summary="Actualizar mercancia",
     *    description="Actualizar una mercancia por su ID",
     *    tags={"Mercancia"},
     *    security={{"bearer_token": {}}},
     *    @OA\Parameter(
     *        name="mercancia",
     *        description="ID de la mercancia",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              required={"nombre","precio","cantidad","tipo_id"},
     *              @OA\Property(property="nombre", type="string", example="Nombre de la mercancia"),
     *              @OA\Property(property="precio", type="integer", example="Precio de la mercancia"),
     *              @OA\Property(property="cantidad", type="integer", example="Cantidad de la mercancia"),
     *              @OA\Property(property="tipo_id", type="string", example="Categoria"),
     *           )
     *       )
     *    ),
     *    @OA\Response(
     *       response=202,
     *       description="Mercancia actualizada",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Mercancia no encontrada"
     *    )
     * )
     */
    public function update(UpdateMercanciasRequest $request, Mercancia $mercancia){
        $this->authorize('Editar mercancias');
        $this->authorize('update', $mercancia);
        $mercancia->update($request->all());

        if ($categorias=json_decode($request->categorias)){ 
            $mercancia->categorias()->sync($categorias);
        }
        return response()->json(new MercanciaResource($mercancia), Response::HTTP_ACCEPTED); //202 Accepted
    }
        /**
     * @OA\Delete(
     *    path="/api/mercancias/{mercancia}",
     *    summary="Eliminar mercancia",
     *    description="Elimina una mercancia por su ID.",
     *    tags={"Mercancia"},
     *    security={{"bearer_token": {}}},
     *    @OA\Parameter(
     *        name="mercancia",
     *        description="ID de la mercancia",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *           type="integer"
     *        )
     *     ),
     *    @OA\Response(
     *       response=204,
     *       description="Mercancia eliminada con éxito",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado",
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Mercancia no encontrada"
     *    )
     * )
     */
    public function destroy(Mercancia $mercancia){
        $this->authorize('Eliminar mercancias');
        $this->authorize('delete', $mercancia);
        $mercancia->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
