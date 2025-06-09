<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModeloAdquirido;
use App\Models\Soporte;
use App\Models\Pago;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = [
        'modelo_adquirido_id',
        'fecha_reporte',
        'status',
        'resultado',
        'danio_reportado_cliente',
        'almacen',
        'observaciones',
        'motivo_no_reparado',
        'numero_nota_credito',
        'nueva_factura',
        'fecha_cierre'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'fecha_reporte' => 'date',
        'fecha_cierre' => 'date'
    ];

    public function modeloAdquirido()
    {
        return $this->belongsTo(ModeloAdquirido::class);
    }

    public function soportes()
    {
        return $this->hasMany(Soporte::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
