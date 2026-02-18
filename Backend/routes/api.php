<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'store']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('index', [AuthController::class, 'index']);
        Route::put('update', [AuthController::class, 'update']);
        Route::get('show/{id}', [AuthController::class, 'show']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('permissions')->group(function () {
    Route::post('/', [PermissionController::class, 'store']);
    Route::put('/{permission}', [PermissionController::class, 'update']);
    Route::delete('/{permission}', [PermissionController::class, 'destroy']);
    Route::get('/{permission}', [PermissionController::class, 'show']);
    Route::get('/', [PermissionController::class, 'index']);
});



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

// Students (CRUD + link to users)
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{student}', [StudentController::class, 'show']);
Route::put('/students/{student}', [StudentController::class, 'update']);
Route::delete('/students/{student}', [StudentController::class, 'destroy']);

// Enrollment (enroll, unenroll, list class students)
Route::post('/enrollments', [EnrollmentController::class, 'enroll']);
Route::delete('/enrollments', [EnrollmentController::class, 'unenroll']);
Route::get('/classes/{class}/students', [EnrollmentController::class, 'listClassStudents']);
