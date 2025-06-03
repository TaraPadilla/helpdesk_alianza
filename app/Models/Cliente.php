<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModeloAdquirido;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nombre',
        'apellido',
        'categoria',
        'telefono',
        'direccion',
        'ciudad',
        'provincia'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function modelosAdquiridos()
    {
        return $this->hasMany(ModeloAdquirido::class);
    }
}
