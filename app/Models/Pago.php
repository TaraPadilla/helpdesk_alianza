<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $ticket_id
 * @property bool $garantia
 * @property decimal $costo_liquidado
 * @property string $status_pago
 * @property string|null $num_factura
 * @property string|null $num_transferencia
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Pago extends Model
{
    use SoftDeletes;

    protected $table = 'pagos';
    
    protected $fillable = [
        'ticket_id',
        'garantia',
        'costo_liquidado',
        'status_pago',
        'num_factura',
        'num_transferencia'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'garantia' => 'boolean',
        'costo_liquidado' => 'decimal:2'
    ];

    protected $attributes = [
        'status_pago' => 'EN TRAMITE'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function validateStatusPago($status)
    {
        $validStatus = ['EN TRAMITE', 'PAGADO'];
        return in_array($status, $validStatus);
    }
}
