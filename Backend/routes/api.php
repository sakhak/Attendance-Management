<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/permissions', [PermissionController::class, 'store']);
Route::put('/permissions/{permission}', [PermissionController::class, 'update']);
Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy']);
Route::get('/permissions/{permission}', [PermissionController::class, 'show']);
Route::get('/permissions', [PermissionController::class, 'index']);


Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/{role}', [RoleController::class, 'show']);
Route::put('/roles/{role}', [RoleController::class, 'update']);
Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

Route::get('/rolepermission', [RolePermissionController::class, 'index']);

Route::prefix('roles/{role}/permissions')->group(function () {
    Route::post('/', [RolePermissionController::class, 'store']);     // attach
    Route::put('/', [RolePermissionController::class, 'update']);     // update
    Route::delete('/', [RolePermissionController::class, 'destroy']); // detach
});
