<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $tipo
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime|null $deleted_at
 */
class Repuesto extends Model
{
    use SoftDeletes;

    protected $table = 'repuestos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo'
    ];

    protected $casts = [
        'deleted_at' => 'datetime'
    ];
}
