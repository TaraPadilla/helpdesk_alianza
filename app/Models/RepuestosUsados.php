<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $soporte_id
 * @property string $codigo_repuesto
 * @property string|null $numero_factura_repuesto
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class RepuestosUsados extends Model
{
    use SoftDeletes;

    protected $table = 'repuestos_usados';
    
    protected $fillable = [
        'soporte_id',
        'codigo_repuesto',
        'numero_factura_repuesto'
    ];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];

    public function soporte()
    {
        return $this->belongsTo(Soporte::class);
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class, 'codigo_repuesto', 'codigo');
    }
}
