<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{
    use SoftDeletes;
    protected $table = 'ciudades';
    protected $fillable = [
        'ciudad',
        'provincia'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function clientes()  
    {
        return $this->hasMany(Cliente::class);
    }
}
