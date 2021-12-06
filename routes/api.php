<?php

use App\Http\Controllers\ArchivoControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Retorna todos los datos
 */
Route::get('/archivos', [ArchivoControlador::class, 'index']);

/**
 * Retorana el dato desde un id
 */

Route::get('/archivos/{id}', [ArchivoControlador::class, 'edit']);

/**
 * Guarda un archivo
 */

Route::post('/archivos', [ArchivoControlador::class, 'store']);

/**
 * Edita un archivo por el id
 */

Route::put('/archivos/{id}', [ArchivoControlador::class, 'update']);

/**
 * Borra un archivo por el id
 */

Route::delete('/archivos/{id}', [ArchivoControlador::class, 'destroy']);

/**
 * Retorna todos los datos por el ref
 */

Route::get('/archivos/ref/{ref}', [ArchivoControlador::class, 'obtenerPorRef']);
