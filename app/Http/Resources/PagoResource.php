<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'garantia' => $this->garantia,
            'costo_liquidado' => $this->costo_liquidado,
            'status_pago' => $this->status_pago,
            'num_factura' => $this->num_factura,
            'num_transferencia' => $this->num_transferencia,
            'ticket' => new TicketResource($this->whenLoaded('ticket')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
