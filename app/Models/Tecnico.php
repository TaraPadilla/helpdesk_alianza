<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Taller;

class Tecnico extends Model
{
    use SoftDeletes;
    
    protected $table = 'tecnicos';
    
    protected $fillable = [
        'documento',
        'nombre',
        'apellido',
        'email',
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
