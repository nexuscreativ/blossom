<?php

use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| BLOSSOM API Routes for Settings and Services
|
*/

// ─── Public Settings ────────────────────────────────────
Route::get('/settings/public', [SettingsController::class, 'index']);
Route::get('/settings/public/{group}', [SettingsController::class, 'group']);

// ─── Admin Services (protected by auth + admin middleware) ───
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::post('/services/{service}/test', [ServiceController::class, 'test']);
    Route::post('/services/{service}/enable', [ServiceController::class, 'enable']);
    Route::post('/services/{service}/disable', [ServiceController::class, 'disable']);
});
