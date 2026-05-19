<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CursorController;

Route::post('/cursor', [CursorController::class, 'move']);
Route::get('/', function () {
    return redirect('/documents');
});

Route::resource('documents', DocumentController::class);