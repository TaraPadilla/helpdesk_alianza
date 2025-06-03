<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModeloAdquiridoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'numero_serie' => $this->numero_serie,
            'fecha_compra' => $this->fecha_compra,
            'numero_factura' => $this->numero_factura,
            'modelo' => [
                'id' => $this->modelo->id,
                'nombre' => $this->modelo->nombre,
                'descripcion' => $this->modelo->descripcion
            ],
            'cliente_id' => $this->cliente_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
