<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $ticket_id
 * @property \DateTime $fecha
 * @property int|null $nps
 * @property string|null $nps_comentario
 * @property int|null $calidad_producto
 * @property string|null $comentario_calidad_producto
 * @property int|null $atencion_cliente
 * @property string|null $comentario_atencion_cliente
 * @property int|null $soporte_tecnico
 * @property string|null $comentario_soporte_tecnico
 * @property int|null $experiencia_compra
 * @property string|null $comentario_experiencia_compra
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Encuesta extends Model
{
    use SoftDeletes;

    protected $table = 'encuestas';
    
    protected $fillable = [
        'ticket_id',
        'fecha',
        'nps',
        'nps_comentario',
        'calidad_producto',
        'comentario_calidad_producto',
        'atencion_cliente',
        'comentario_atencion_cliente',
        'soporte_tecnico',
        'comentario_soporte_tecnico',
        'experiencia_compra',
        'comentario_experiencia_compra'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'fecha' => 'date',
        'nps' => 'integer',
        'calidad_producto' => 'integer',
        'atencion_cliente' => 'integer',
        'soporte_tecnico' => 'integer',
        'experiencia_compra' => 'integer'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function validateNps($nps)
    {
        if ($nps !== null && ($nps < 0 || $nps > 10)) {
            throw new \InvalidArgumentException('NPS debe estar entre 0 y 10');
        }
    }

    public function validateCalificacion($calificacion)
    {
        if ($calificacion !== null && ($calificacion < 1 || $calificacion > 5)) {
            throw new \InvalidArgumentException('La calificación debe estar entre 1 y 5');
        }
    }
}
