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
    return view('welcome');
});

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
});

// Repuestos Routes
Route::prefix('repuestos')->group(function () {
    Route::get('buscar', [RepuestoController::class, 'filterByName'])->name('repuestos.buscar');
    Route::resource('repuestos', RepuestoController::class);
});

// RepuestosUsados Routes
Route::prefix('repuestos-usados')->group(function () {
    Route::get('soporte/{soporte}', [RepuestosUsadosController::class, 'repuestosUsadosPorSoporte'])
        ->name('repuestos-usados.soporte');
    Route::get('repuesto/{repuesto}', [RepuestosUsadosController::class, 'repuestosUsadosPorRepuesto'])
        ->name('repuestos-usados.repuesto');
    Route::resource('repuestos-usados', RepuestosUsadosController::class);
});

// Pagos Routes
Route::prefix('pagos')->group(function () {
    Route::resource('pagos', PagoController::class);
    Route::get('pagos/ticket/{ticket}', [PagoController::class, 'pagosPorTicket'])
        ->name('pagos.ticket');
    Route::get('pagos/status/{status}', [PagoController::class, 'pagosPorStatus'])
        ->name('pagos.status');
});
