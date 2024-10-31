<?php

use App\Http\Controllers\FilepondController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FilepondController::class, 'index'])->name('user.index');
Route::post('/post', [FilepondController::class, 'post'])->name('user.post');
