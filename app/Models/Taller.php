<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnico;
use App\Models\Ciudad;

class Taller extends Model
{
    protected $table = 'talleres';
    protected $fillable = [
        'nombre',
        'ciudad_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function tecnicos()
    {
        return $this->hasMany(Tecnico::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
}
