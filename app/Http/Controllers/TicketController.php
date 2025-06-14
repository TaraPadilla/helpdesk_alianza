<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\ModeloAdquirido;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function index()
    {
        return TicketResource::collection(
            Ticket::with('modeloAdquirido.modelo.producto.linea','modeloAdquirido.cliente')
            ->orderBy('id', 'desc')
            ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Ticket', ['request' => $request->all()]);
            $validated = $request->validate([
            'modelo_adquirido_id' => 'required|exists:modelos_adquiridos,id',
            'fecha_reporte' => 'required|date',
            'status' => 'required|string',
            'resultado' => 'nullable|string',
            'danio_reportado_cliente' => 'nullable|string',
            'almacen' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'motivo_no_reparado' => 'nullable|string',
            'numero_nota_credito' => 'nullable|string',
            'nueva_factura' => 'nullable|string',
            'fecha_cierre' => 'nullable|date',
        ]);

        $ticket = Ticket::create($validated);
        
        return new TicketResource($ticket->load('modeloAdquirido.modelo'));
        } catch (\Exception $e) {
            Log::error('Error al guardar el ticket', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al guardar el ticket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket->load('modeloAdquirido.modelo'));
    }

    public function update(Request $request, Ticket $ticket)
    {   
        try {
        Log::info('update Ticket', ['ticket' => $ticket]);
        $validated = $request->validate([
            'modelo_adquirido_id' => 'sometimes|required|exists:modelos_adquiridos,id',
            'fecha_reporte' => 'sometimes|required|date',
            'status' => 'sometimes|required|string',
            'resultado' => 'nullable|string',
            'danio_reportado_cliente' => 'nullable|string',
            'almacen' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'motivo_no_reparado' => 'nullable|string',
            'numero_nota_credito' => 'nullable|string',
            'nueva_factura' => 'nullable|string',
            'fecha_cierre' => 'nullable|date',
        ]);
        Log::info('update Ticket', ['validated' => $validated]);
        $ticket->update($validated);
        Log::info('update done Ticket', ['ticket' => $ticket]);
        return new TicketResource($ticket->load('modeloAdquirido.modelo'));
        } catch (\Throwable $e) {
            Log::error('Error en update Ticket', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al actualizar'], 500);
        }
    }

    public function destroy(Ticket $ticket)
    {
        try {
            $ticket->delete();
            return response()->noContent();
        } catch (\Throwable $e) {
            Log::error('Error en destroy Ticket', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }

    public function ticketsPorModeloAdquirido(ModeloAdquirido $modeloAdquirido)
    {
        return TicketResource::collection($modeloAdquirido->tickets()->get());
    }

    public function generarPDF(Ticket $ticket)
    {
        try {
            $ticket->load([
                'modeloAdquirido.cliente',
                'modeloAdquirido.modelo.producto.linea',
                'modeloAdquirido.modelo.origen',
                'soportes.tecnico.taller',
                'pagos',
                'encuestas'
            ]);

            return response()->json([
                'data' => new TicketResource($ticket)
            ]);
            
        } catch (\Throwable $e) {
            \Log::error('Error al generar reporte del ticket', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al generar el reporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
