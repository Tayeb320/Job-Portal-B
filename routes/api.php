<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
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

Route::prefix('v10')->group(function() {
    Route::middleware(['CheckApiKey'])->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::get('jobs', [JobController::class,'jobs']);
        Route::get('job-detail/{slug}', [JobController::class,'jobDetail']);

        Route::middleware(['jwt.verify'])->group(function () {
            Route::post('apply-job', [AuthController::class, 'applyJob']);
        });
    });
});
