<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Origen;
use App\Models\ModeloAdquirido;

class Modelo extends Model
{
    protected $table = 'modelos';
    protected $fillable = [
        'nombre',
        'producto_id',
        'origen_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class);
    }

    public function modelosAdquiridos()
    {
        return $this->hasMany(ModeloAdquirido::class);
    }
}
