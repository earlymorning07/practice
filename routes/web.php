<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;


// READ
Route::get('/', [Controller::class, 'index']);

Route::get('/products', [Controller::class, 'index']);


// CREATE
Route::get('/products/create', [Controller::class, 'create']);

Route::post('/products/store', [Controller::class, 'store']);


// UPDATE
Route::get('/products/edit/{id}', [Controller::class, 'edit']);

Route::post('/products/update/{id}', [Controller::class, 'update']);


// DELETE
Route::post('/products/delete/{id}', [Controller::class, 'destroy']);