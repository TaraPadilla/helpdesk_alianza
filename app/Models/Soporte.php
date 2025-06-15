<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $ticket_id
 * @property int $tecnico_id
 * @property \DateTime $fecha_visita
 * @property string $descripcion_dano
 * @property string $descripcion_reparacion
 * @property string $parte_afectada
 * @property string $orden_trabajo
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Soporte extends Model
{
    use SoftDeletes;

    protected $table = 'soportes';
    
    protected $fillable = [
        'ticket_id',
        'tecnico_id',
        'fecha_visita',
        'descripcion_dano',
        'descripcion_reparacion',
        'parte_afectada',
        'orden_trabajo',
        'resultado',
        'nueva_factura',
        'motivo'
    ];

    protected $casts = [
        'fecha_visita' => 'date',
        'deleted_at' => 'datetime'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function repuestosUsados()
    {
        return $this->hasMany(RepuestosUsados::class);
    }
}
