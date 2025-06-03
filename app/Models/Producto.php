<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Linea;
use App\Models\Modelo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'linea_id'
    ];
    protected $dates = ['deleted_at'];

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
