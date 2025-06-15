<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
class SoporteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'tecnico_id' => $this->tecnico_id,
            'fecha_visita' => $this->fecha_visita,
            'descripcion_dano' => $this->descripcion_dano,
            'descripcion_reparacion' => $this->descripcion_reparacion,
            'parte_afectada' => $this->parte_afectada,
            'orden_trabajo' => $this->orden_trabajo,
            'resultado' => $this->resultado,
            'nueva_factura' => $this->nueva_factura,
            'motivo' => $this->motivo,
            'repuestos_usados' => RepuestosUsadosResource::collection($this->whenLoaded('repuestosUsados'))
        ];
    }
}
