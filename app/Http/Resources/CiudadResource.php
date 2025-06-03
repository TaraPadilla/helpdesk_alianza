<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CiudadResource extends JsonResource
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
            'ciudad' => $this->ciudad,
            'provincia' => $this->provincia,
            'clientes_count' => $this->whenLoaded('clientes', function () {
                return $this->clientes()->count();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
