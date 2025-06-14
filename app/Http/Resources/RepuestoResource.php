<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
class RepuestoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cod_interno' => $this->cod_interno,
            'descripcion' => $this->descripcion,
            'codigo_proveedor' => $this->codigo_proveedor,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
