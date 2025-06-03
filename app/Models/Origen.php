<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modelo;

class Origen extends Model
{
    protected $table = 'origenes';
    protected $fillable = [
        'nombre'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
