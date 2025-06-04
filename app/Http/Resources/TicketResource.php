<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'modelo_adquirido' => [
                'id' => $this->modeloAdquirido->id,
                'numero_serie' => $this->modeloAdquirido->numero_serie,
                'modelo' => [
                    'id' => $this->modeloAdquirido->modelo->id,
                    'nombre' => $this->modeloAdquirido->modelo->nombre
                ]
            ],
            'fecha_reporte' => $this->fecha_reporte,
            'status' => $this->status,
            'resultado' => $this->resultado,
            'danio_reportado_cliente' => $this->danio_reportado_cliente,
            'almacen' => $this->almacen,
            'observaciones' => $this->observaciones,
            'motivo_no_reparado' => $this->motivo_no_reparado,
            'numero_nota_credito' => $this->numero_nota_credito,
            'nueva_factura' => $this->nueva_factura,
            'fecha_cierre' => $this->fecha_cierre,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
