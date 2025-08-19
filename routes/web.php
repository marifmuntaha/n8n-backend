<?php

use App\Http\Controllers\Master\TransactionController as MasterTransactionController;
use App\Http\Controllers\Student\TransactionController as StudentTransactionController;
use App\Http\Controllers\WhatsappController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => EnsureTokenIsValid::class], function () {
    Route::prefix('n8n')->group(function () {
        Route::post('whatsapp', [WhatsappController::class, 'index']);
    });
    Route::prefix('master')->group(function () {
        Route::apiResource('transaction', MasterTransactionController::class);
    });
    Route::prefix('student')->group(function () {
        Route::apiResource('transaction', StudentTransactionController::class);
    });
});
Route::post('n8n/whatsapp/testing', [WhatsappController::class, 'index']);
