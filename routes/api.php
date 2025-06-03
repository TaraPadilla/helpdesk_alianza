<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\OrigenController;


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
    // Lineas
    Route::resource('lineas', LineaController::class);
    
    // Productos
    Route::resource('productos', ProductoController::class);
    
    // Modelos
    Route::resource('modelos', ModeloController::class);
    
    // Origenes
    Route::resource('origenes', OrigenController::class)->parameters([
        'origenes' => 'origen'
    ]);
    
});
