<?php

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
});
