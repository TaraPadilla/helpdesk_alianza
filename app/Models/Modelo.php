<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Origen;
use App\Models\ModeloAdquirido;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    use SoftDeletes;
    protected $table = 'modelos';
    protected $fillable = [
        'nombre',
        'producto_id',
        'origen_id'
    ];
    protected $dates = ['deleted_at'];

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
