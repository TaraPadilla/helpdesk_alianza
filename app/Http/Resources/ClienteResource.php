<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ModeloAdquiridoResource;
use App\Http\Resources\CiudadResource;

class ClienteResource extends JsonResource
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
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'categoria' => $this->categoria,
            'documento' => $this->documento,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'email' => $this->email,
            'ciudad' => $this->whenLoaded('ciudad', function () {
                return new CiudadResource($this->ciudad);
            }),
            'modelos_adquiridos' => ModeloAdquiridoResource::collection($this->whenLoaded('modelosAdquiridos')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
