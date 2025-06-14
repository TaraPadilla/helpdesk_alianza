<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'rol',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }
}
