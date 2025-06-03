<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Taller;

class Tecnico extends Model
{
    protected $table = 'tecnicos';
    protected $fillable = [
        'nombre',
        'taller_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }
}
