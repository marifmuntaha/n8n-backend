<?php

use App\Http\Controllers\Master\TransactionController as MasterTransactionController;
use App\Http\Controllers\Master\TransactionDetailController;
use App\Http\Controllers\Student\TransactionController as StudentTransactionController;
use App\Http\Controllers\Teller\TransactionController as TellerTransactionController;
use App\Http\Controllers\WhatsappController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => EnsureTokenIsValid::class], function () {
    Route::prefix('master')->group(function () {
        Route::apiResource('transaction', MasterTransactionController::class);
        Route::apiResource('transaction-detail', TransactionDetailController::class);
    });
    Route::prefix('teller')->group(function () {
        Route::apiResource('transaction', TellerTransactionController::class);
    });
    Route::prefix('student')->group(function () {
        Route::apiResource('transaction', StudentTransactionController::class);
    });
    Route::prefix('n8n')->group(function () {
        Route::post('whatsapp', [WhatsappController::class, 'index']);
    });
});
