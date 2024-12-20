<?php

use App\Http\Controllers\FraisController;
use App\Http\Controllers\VisiteurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/visiteur/initpwds',[VisiteurController::class,'initPasswords']);

Route::post('/visiteur/login',[VisiteurController::class, 'login']);

Route::get('/visiteur/logout',[VisiteurController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/visiteur/unauthorized',[VisiteurController::class, 'unauthorized'])->name('login');

Route::get('/frais/{idfrais}', [FraisController::class, 'getFrais'])->middleware('auth:sanctum');

Route::post('/frais/ajout', [FraisController::class, 'ajout'])->middleware('auth:sanctum');

Route::post('/frais/modif',[FraisController::class, 'modif'])->middleware('auth:sanctum');

Route::delete('/frais/suppr',[FraisController::class, 'suppr'])->middleware('auth:sanctum');

Route::get('/frais/liste/{id_visiteur}',[FraisController::class,'liste']);
