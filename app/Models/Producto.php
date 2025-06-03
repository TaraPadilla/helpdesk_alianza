<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Linea;
use App\Models\Modelo;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'linea_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function linea()
    {
        return $this->belongsTo(Linea::class);
    }

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
