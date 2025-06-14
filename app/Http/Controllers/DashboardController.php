<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Tecnico;
use App\Models\Taller;
use App\Models\Repuesto;
use App\Models\RepuestosUsados;
use App\Models\Encuesta;
use App\Models\Pago;
use App\Models\ImagenTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function resumen()
    {
        // Tickets por estado
        $ticketsByStatus = DB::table('tickets')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Tickets por mes (últimos 12)
        $ticketsByMonth = DB::table('tickets')
            ->selectRaw("DATE_FORMAT(fecha_reporte, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
        ->get();
        // Tickets por ciudad
        $ticketsByCity = DB::table('tickets')
        ->join('modelos_adquiridos', 'tickets.modelo_adquirido_id', '=', 'modelos_adquiridos.id')
        ->join('clientes', 'modelos_adquiridos.cliente_id', '=', 'clientes.id')
        ->join('ciudades', 'clientes.ciudad_id', '=', 'ciudades.id')
        ->select('ciudades.ciudad as city', DB::raw('COUNT(*) as count'))
        ->groupBy('ciudades.ciudad')
        ->get();

        $satisfactionMetrics = DB::table('encuestas')
        ->selectRaw("
            AVG(nps) as nps,
            AVG(calidad_producto) as calidad_producto,
            AVG(atencion_cliente) as atencion_cliente,
            AVG(soporte_tecnico) as soporte_tecnico,
            AVG(experiencia_compra) as experiencia_compra
        ")
        ->first();

        $metrics = collect([
            ['category' => 'NPS', 'averageScore' => round($satisfactionMetrics->nps, 1)],
            ['category' => 'Calidad del Producto', 'averageScore' => round($satisfactionMetrics->calidad_producto, 1)],
            ['category' => 'Atención al Cliente', 'averageScore' => round($satisfactionMetrics->atencion_cliente, 1)],
            ['category' => 'Soporte Técnico', 'averageScore' => round($satisfactionMetrics->soporte_tecnico, 1)],
            ['category' => 'Experiencia de Compra', 'averageScore' => round($satisfactionMetrics->experiencia_compra, 1)],
        ]);

        $ticketsAbiertos = DB::table('tickets')
        ->whereIn('status', ['SIN ATENDER', 'EN PROCESO', 'PENDIENTE REPUESTO'])
        ->count();

        $promedioDiasPrimeraVisita = DB::table('tickets')
        ->join(DB::raw('(
            SELECT ticket_id, MIN(fecha_visita) as primera_visita
            FROM soportes
            GROUP BY ticket_id
        ) as primeras'), 'tickets.id', '=', 'primeras.ticket_id')
        ->selectRaw('AVG(DATEDIFF(primeras.primera_visita, tickets.fecha_reporte)) as promedio')
        ->value('promedio');

        return response()->json([
            'data' => [
            'tickets_by_status' => $ticketsByStatus,
            'tickets_by_month' => $ticketsByMonth,
            'tickets_by_city' => $ticketsByCity,    
            'metrics' => $metrics,
            'tickets_abiertos' => $ticketsAbiertos,
            'promedio_visita' => round($promedioDiasPrimeraVisita, 1),
            ]
        ]);
    }
}
