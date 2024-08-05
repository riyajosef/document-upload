<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php


Route::get('upload', [DocumentController::class, 'create']);
Route::post('upload', [DocumentController::class, 'store']);
