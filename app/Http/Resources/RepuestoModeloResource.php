<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepuestoModeloResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'modelo_id' => $this->modelo_id,
            'repuesto_id' => $this->repuesto_id,
            'modelo' => new ModeloResource($this->whenLoaded('modelo')),
            'repuesto' => new RepuestoResource($this->whenLoaded('repuesto')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
