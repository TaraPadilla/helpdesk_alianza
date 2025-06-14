<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ModeloAdquiridoResource;
use App\Http\Resources\SoporteResource;
use App\Http\Resources\PagoResource;
use App\Http\Resources\EncuestaResource;


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
                    'nombre' => $this->modeloAdquirido->modelo->nombre,
                    'producto' => [
                        'id' => $this->modeloAdquirido->modelo->producto->id,
                        'nombre' => $this->modeloAdquirido->modelo->producto->nombre,
                        'linea' => [
                            'id' => $this->modeloAdquirido->modelo->producto->linea->id,
                            'nombre' => $this->modeloAdquirido->modelo->producto->linea->nombre
                        ]
                    ],
                    'origen' => [
                        'id' => $this->modeloAdquirido->modelo->origen->id,
                        'nombre' => $this->modeloAdquirido->modelo->origen->nombre
                    ]
                ],
                'cliente' => [
                    'id' => $this->modeloAdquirido->cliente->id,
                    'nombre' => $this->modeloAdquirido->cliente->nombre,
                    'apellido' => $this->modeloAdquirido->cliente->apellido,
                    'documento' => $this->modeloAdquirido->cliente->documento,
                    'email' => $this->modeloAdquirido->cliente->email,
                    'telefono' => $this->modeloAdquirido->cliente->telefono,
                    'direccion' => $this->modeloAdquirido->cliente->direccion
                ],
                'fecha_compra' => $this->modeloAdquirido->fecha_compra,
                'numero_factura' => $this->modeloAdquirido->numero_factura,
            ],
            'fecha_reporte' => $this->fecha_reporte,
            'status' => $this->status,
            
            'danio_reportado_cliente' => $this->danio_reportado_cliente,
            'almacen' => $this->almacen,
            'observaciones' => $this->observaciones,
            'motivo_no_reparado' => $this->motivo_no_reparado,
            'numero_nota_credito' => $this->numero_nota_credito,
            'nueva_factura' => $this->nueva_factura,
            'fecha_cierre' => $this->fecha_cierre,
            'soportes' => SoporteResource::collection($this->soportes),
            'pagos' => PagoResource::collection($this->pagos),
            'encuestas' => EncuestaResource::collection($this->encuestas),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,  
        ];
    }
}
