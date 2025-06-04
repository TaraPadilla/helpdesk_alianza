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
        'documento',
        'apellido',
        'categoria',
        'telefono',
        'direccion',
        'email',
        'ciudad_id',
        'documento'
    ];
    
    protected $casts = [
        'deleted_at' => 'datetime',
        'documento' => 'integer'
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
