<?php

use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\ClassesController;
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

Route::get('/classes', [ClassesController::class, 'index']);
Route::post('/classes', [ClassesController::class, 'store']);
Route::get('/classes/{class}', [ClassesController::class, 'show']);
Route::put('/classes/{class}', [ClassesController::class, 'update']);
Route::delete('/classes/{class}', [ClassesController::class, 'destroy']);

Route::get('/blacklists', [BlacklistController::class, 'index']);
Route::post('/blacklists', [BlacklistController::class, 'store']);
Route::get('/blacklists/{blacklist}', [BlacklistController::class, 'show']);
Route::put('/blacklists/{blacklist}', [BlacklistController::class, 'update']);
Route::delete('/blacklists/{blacklist}', [BlacklistController::class, 'destroy']);

Route::get('/class-teachers', [ClassTeacherController::class, 'index']);
Route::post('/class-teachers', [ClassTeacherController::class, 'store']);
Route::get('/class-teachers/{classTeacher}', [ClassTeacherController::class, 'show']);
Route::put('/class-teachers/{classTeacher}', [ClassTeacherController::class, 'update']);
Route::delete('/class-teachers/{classTeacher}', [ClassTeacherController::class, 'destroy']);
