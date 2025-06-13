<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EncuestaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'fecha' => $this->fecha,
            'nps' => $this->nps,
            'nps_comentario' => $this->nps_comentario,
            'calidad_producto' => $this->calidad_producto,
            'comentario_calidad_producto' => $this->comentario_calidad_producto,
            'atencion_cliente' => $this->atencion_cliente,
            'comentario_atencion_cliente' => $this->comentario_atencion_cliente,
            'soporte_tecnico' => $this->soporte_tecnico,
            'comentario_soporte_tecnico' => $this->comentario_soporte_tecnico,
            'experiencia_compra' => $this->experiencia_compra,
            'comentario_experiencia_compra' => $this->comentario_experiencia_compra,
            'ticket' => $this->whenLoaded('ticket', function () {
                return [
                    'id' => $this->ticket->id,
                    'modelo_adquirido' => $this->ticket->modeloAdquirido ? [
                        'id' => $this->ticket->modeloAdquirido->id,
                        'numero_serie' => $this->ticket->modeloAdquirido->numero_serie,
                        'fecha_compra' => $this->ticket->modeloAdquirido->fecha_compra,
                        'numero_factura' => $this->ticket->modeloAdquirido->numero_factura,
                        'cliente' => $this->ticket->modeloAdquirido->cliente ? [
                            'id' => $this->ticket->modeloAdquirido->cliente->id,
                            'nombre' => $this->ticket->modeloAdquirido->cliente->nombre,
                            'apellido' => $this->ticket->modeloAdquirido->cliente->apellido,
                            'email' => $this->ticket->modeloAdquirido->cliente->email,
                            'telefono' => $this->ticket->modeloAdquirido->cliente->telefono
                        ] : null,
                        'modelo' => $this->ticket->modeloAdquirido->modelo ? [
                            'id' => $this->ticket->modeloAdquirido->modelo->id,
                            'nombre' => $this->ticket->modeloAdquirido->modelo->nombre
                        ] : null
                    ] : null
                ];
            })
        ];
    }
}
