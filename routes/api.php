<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductApiController;

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

// Public Routes (Plugin Login)
Route::middleware('throttle:5,1')->post('/v1/login', [AuthController::class, 'login']);

// Public Download Route (processes token manually to support native WP Upgrader download requests)
Route::middleware('throttle:10,1')->get('/v1/download/{id}', [ProductApiController::class, 'download']);

// Protected Routes (Plugin Actions)
Route::middleware(['auth:sanctum', 'plugin.access', 'throttle:60,1'])->prefix('v1')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/site/sync', [AuthController::class, 'syncInstalledResources']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Products & Downloads
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::post('/check-updates', [ProductApiController::class, 'checkUpdates']);
});