<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TagController;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('/', FavoriteController::class);
Route::put('/{id}', [FavoriteController::class, 'update']);
Route::delete('/{favorite}', [FavoriteController::class, 'destroy']);


