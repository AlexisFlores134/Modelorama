<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MercanciaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => 'mercancia',
            'atributos' => [
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'cantidad' => $this->cantidad,
                'tipo_id' => $this->tipo_id,
                'autor' => $this->user->name,
            ]
        ];
    }
}
