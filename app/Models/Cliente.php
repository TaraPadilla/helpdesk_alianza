<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModeloAdquirido;
use App\Models\Ciudad;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nombre',
        'apellido',
        'categoria',
        'telefono',
        'direccion',
        'ciudad_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function modelosAdquiridos()
    {
        return $this->hasMany(ModeloAdquirido::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
}
