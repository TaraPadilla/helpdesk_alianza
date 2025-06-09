<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepuestosUsadosResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'soporte_id' => $this->soporte_id,
            'codigo_repuesto' => $this->codigo_repuesto,
            'numero_factura_repuesto' => $this->numero_factura_repuesto,
            'repuesto' => new RepuestoResource($this->whenLoaded('repuesto')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
