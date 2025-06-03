<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/conexion-test', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Conexión exitosa a MySQL';
    } catch (\Exception $e) {
        return '❌ Error de conexión: ' . $e->getMessage();
    }
});

Route::get('/', function () {
    return view('welcome');
});
