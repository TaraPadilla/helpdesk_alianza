<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagenTicketResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'ruta' => $this->ruta,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
