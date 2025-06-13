<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Http\Resources\EncuestaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

class EncuestaController extends Controller
{
    public function index()
    {
        return EncuestaResource::collection(
            Encuesta::with([
                'ticket.modeloAdquirido.cliente',
                'ticket.modeloAdquirido.modelo'
            ])->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Encuesta', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'fecha' => 'required|date',
                'nps' => 'nullable|integer|min:0|max:10',
                'nps_comentario' => 'nullable|string',
                'calidad_producto' => 'nullable|integer|min:1|max:5',
                'comentario_calidad_producto' => 'nullable|string',
                'atencion_cliente' => 'nullable|integer|min:1|max:5',
                'comentario_atencion_cliente' => 'nullable|string',
                'soporte_tecnico' => 'nullable|integer|min:1|max:5',
                'comentario_soporte_tecnico' => 'nullable|string',
                'experiencia_compra' => 'nullable|integer|min:1|max:5',
                'comentario_experiencia_compra' => 'nullable|string',
            ]);

            $encuesta = Encuesta::create($validated);
            return new EncuestaResource($encuesta);
        } catch (\Exception $e) {
            Log::error('Error creating encuesta', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Encuesta $encuesta)
    {
        return new EncuestaResource($encuesta->loadMissing([
            'ticket.modeloAdquirido.cliente',
            'ticket.modeloAdquirido.modelo'
        ]));
    }

    public function update(Request $request, Encuesta $encuesta)
    {
        try {
            $validated = $request->validate([
                'ticket_id' => 'sometimes|required|exists:tickets,id',
                'fecha' => 'sometimes|required|date',
                'nps' => 'sometimes|nullable|integer|min:0|max:10',
                'nps_comentario' => 'sometimes|nullable|string',
                'calidad_producto' => 'sometimes|nullable|integer|min:1|max:5',
                'comentario_calidad_producto' => 'sometimes|nullable|string',
                'atencion_cliente' => 'sometimes|nullable|integer|min:1|max:5',
                'comentario_atencion_cliente' => 'sometimes|nullable|string',
                'soporte_tecnico' => 'sometimes|nullable|integer|min:1|max:5',
                'comentario_soporte_tecnico' => 'sometimes|nullable|string',
                'experiencia_compra' => 'sometimes|nullable|integer|min:1|max:5',
                'comentario_experiencia_compra' => 'sometimes|nullable|string',
            ]);

            $encuesta->update($validated);
            return new EncuestaResource($encuesta->loadMissing(['ticket']));
        } catch (\Exception $e) {
            Log::error('Error updating encuesta', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Encuesta $encuesta)
    {
        $encuesta->delete();
        return response()->noContent();
    }

    public function encuestasPorTicket(Ticket $ticket)
    {
        return EncuestaResource::collection(
            $ticket->encuestas()->with([
                'ticket.modeloAdquirido.cliente',
                'ticket.modeloAdquirido.modelo'
            ])->get()
        );
    }

    public function encuestasPorFecha(Request $request)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        return EncuestaResource::collection(
            Encuesta::whereBetween('fecha', [$validated['fecha_inicio'], $validated['fecha_fin']])
                ->with('ticket')
                ->get()
        );
    }
}
