<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linea extends Model
{
    use SoftDeletes;

    protected $table = 'lineas';
    protected $dates = ['deleted_at'];

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
