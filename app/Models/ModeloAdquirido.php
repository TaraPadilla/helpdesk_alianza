<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Modelo;
use App\Models\Ticket;

class ModeloAdquirido extends Model
{
    protected $table = 'modelos_adquiridos';
    protected $fillable = [
        'numero_serie',
        'fecha_compra',
        'numero_factura',
        'cliente_id',
        'modelo_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'fecha_compra' => 'date'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
