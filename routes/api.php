<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Person\PersonaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ? autenticacion
Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// !CRUD Usuario
Route::get("/usuario", [UsuarioController::class, 'listar']);
// Route::post("/usuario", [UsuarioController::class, 'gardar']);
// Route::get("/usuario/{id}", [UsuarioController::class, 'mostrar']);
// Route::put("/usuario/{id}", [UsuarioController::class, 'actualizar']);
// Route::dete("/usuario/{id}", [UsuarioController::class, 'eliminar']);

// CRUD Persona Usuario
Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('v1/person')->group(function(){
        Route::get("/persona", [PersonaController::class, 'listar']);
        Route::post("/persona", [PersonaController::class, 'guardar']);
        Route::get("/persona/{id}", [PersonaController::class, 'mostrar']);
        Route::put("/persona/{id}", [PersonaController::class, 'actualizar']);
        Route::delete("/persona/{id}", [PersonaController::class, 'eliminar']);
    });

    Route::prefix('v1/configuration')->group(function(){
    });
});



