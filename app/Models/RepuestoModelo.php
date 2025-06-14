<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepuestoModelo extends Model
{
    use SoftDeletes;
    protected $table = 'repuesto_modelo';
    protected $fillable = [
        'modelo_id',
        'repuesto_id',
    ];
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }
}
