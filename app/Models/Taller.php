<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnico;

class Taller extends Model
{
    protected $table = 'talleres';
    protected $fillable = [
        'nombre',
        'ubicacion'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tecnicos()
    {
        return $this->hasMany(Tecnico::class);
    }
}
