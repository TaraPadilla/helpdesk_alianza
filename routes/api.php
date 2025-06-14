<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\OrigenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ModeloAdquiridoController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\RepuestosUsadosController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\ImagenTicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepuestoModeloController;

Route::get('/conexion-test', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Conexión exitosa a MySQL';
    } catch (\Exception $e) {
        return '❌ Error de conexión: ' . $e->getMessage();
    }
});

Route::get('/cors-test', function () {
    return response()->json(['status' => 'ok']);
});


Route::get('/', function () {
    return response()->json(['status' => 'API OK']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('perfil', function (Request $request) {
        return response()->json([
            'data' => $request->user()
        ]);
    });

    Route::apiResource('usuarios', UsuarioController::class);

    // Product Catalog Routes
    Route::prefix('catalogo')->group(function () {
        Route::resource('lineas', LineaController::class);
        Route::get('productos/linea/{linea}', [ProductoController::class, 'filterByLinea']);
        Route::resource('productos', ProductoController::class);
        Route::get('modelos/producto/{producto}', [ModeloController::class, 'filterByProducto']);
        Route::resource('modelos', ModeloController::class);
        Route::resource('origenes', OrigenController::class)->parameters([
            'origenes' => 'origen'
        ]);
    });
});

Route::post('login', [AuthController::class, 'login'])->name('login');

// Dashboard Routes
Route::get('/dashboard/resumen', [DashboardController::class, 'resumen']);


// Gestion Clientes Routes
Route::prefix('gestion')->group(function () {
    Route::get('clientes/categorias', [ClienteController::class, 'getCategorias']);
    Route::resource('clientes', ClienteController::class);
    Route::get('ciudades/provincia/{provincia}', [CiudadController::class, 'ciudadesPorProvincia']);
    Route::resource('ciudades', CiudadController::class)->parameters([
        'ciudades' => 'ciudad'
    ]);
});

// Tickets Routes
Route::prefix('helpdesk')->group(function () {
    Route::get('/tickets/max-id', [TicketController::class, 'maxId']);
    Route::put('/tickets/{ticket}/status', [TicketController::class, 'actualizarStatus']);
    Route::get('/tickets/{ticket}/pdf', [TicketController::class, 'generarPDF']);
    Route::resource('tickets', TicketController::class);
    Route::resource('modelos-adquiridos', ModeloAdquiridoController::class)
    ->parameters([
        'modelos-adquiridos' => 'modeloAdquirido'
    ]);
});

// Técnicos Routes
Route::prefix('tecnico')->group(function () {
    Route::resource('talleres', TallerController::class)->parameters([
        'talleres' => 'taller'
    ]);
    Route::resource('tecnicos', TecnicoController::class);
    Route::resource('soportes', SoporteController::class);
    Route::get('soportes/ticket/{ticket}', [SoporteController::class, 'soportePorTicket'])->name('soportes.ticket');
    Route::resource('repuestos', RepuestoController::class);
    //Repuesto por soporte
    Route::get('repuestos-usados/soporte/{soporte}', 
              [RepuestosUsadosController::class, 'repuestosUsadosPorSoporte'])->name('repuestos-usados.soporte');
    Route::resource('repuestos-usados', RepuestosUsadosController::class)->parameters([
        'repuestos-usados' => 'repuestosUsados'
    ]);
    Route::resource('repuesto-modelos', RepuestoModeloController::class)->parameters([
        'repuesto-modelos' => 'repuestoModelo'
    ]);
});

// Usuarios API Resource
Route::apiResource('usuarios', UsuarioController::class);

// Usuarios API Resource
Route::resource('encuestas', EncuestaController::class);

// Encuestas Routes
Route::prefix('encuestas')->group(function () {
    Route::get('ticket/{ticket}', [EncuestaController::class, 'encuestasPorTicket'])
        ->name('encuestas.ticket');
    Route::get('fecha', [EncuestaController::class, 'encuestasPorFecha'])
        ->name('encuestas.fecha');

});

// Pagos Routes
Route::prefix('pagos')->group(function () {
    Route::resource('pagos', PagoController::class);
    Route::get('pagos/ticket/{ticket}', [PagoController::class, 'pagosPorTicket'])
        ->name('pagos.ticket');
    Route::get('pagos/status/{status}', [PagoController::class, 'pagosPorStatus'])
        ->name('pagos.status');
});

// Imagenes Routes

Route::post('/imagenes-ticket', [ImagenTicketController::class, 'store']);
Route::get('/imagenes-ticket', [ImagenTicketController::class, 'index']);
Route::get('/imagenes-ticket/{ticket_id}', [ImagenTicketController::class, 'indexTicket']);
Route::delete('/imagenes-ticket/{imagenTicket}', [ImagenTicketController::class, 'destroy']);


