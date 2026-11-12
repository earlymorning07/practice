<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// READ
Route::get('/', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

// CREATE
Route::post('/products/store', [ProductController::class, 'store']);

// UPDATE
Route::post('/products/update/{id}', [ProductController::class, 'update']);

// DELETE
Route::post('/products/delete/{id}', [ProductController::class, 'destroy']);