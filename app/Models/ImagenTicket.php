<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImagenTicket extends Model
{
    use SoftDeletes;

    protected $table = 'imagenes_ticket';

    protected $fillable = [
        'ticket_id',
        'ruta',
        'descripcion',
        'tipo',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
