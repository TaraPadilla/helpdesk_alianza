<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modelo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Origen extends Model
{
    use SoftDeletes;
    protected $table = 'origenes';
    protected $fillable = [
        'nombre'
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
