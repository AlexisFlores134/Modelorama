<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mercancia;
use App\Http\Resources\MercanciaResource;
use App\Http\Requests\StoreMercanciasRequest;
use App\Http\Requests\UpdateMercanciasRequest;
use Symfony\Component\HttpFoundation\Response;

class MercanciaController extends Controller
{
    public function index(){
        $mercancias = Mercancia::with('categorias')->get();
        return MercanciaResource::collection($mercancias);
    }
    public function store(StoreMercanciasRequest $request){
        $mercancia=Mercancia::create($request->all());
        $mercancia->categorias()->attach(json_decode($request->categorias));
        return response()->json(new MercanciaResource($mercancia), Response::HTTP_CREATED);
    }
    public function show(Mercancia $mercancia){
        $mercancia=$mercancia->load('categorias');
        return new MercanciaResource($mercancia);
    }
    public function update(UpdateMercanciasRequest $request, Mercancia $mercancia){
        $mercancia->update($request->all());
        if ($categorias=json_decode($request->categorias)){ 
            $mercancia->categorias()->sync($categorias);
        }
        return response()->json(new MercanciaResource($mercancia), Response::HTTP_ACCEPTED);
    }
    public function destroy(Mercancia $mercancia){
        $mercancia->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
