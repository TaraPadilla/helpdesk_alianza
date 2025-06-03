<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Linea extends Model
{
    protected $table = 'lineas';
    protected $fillable = [
        'nombre'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
