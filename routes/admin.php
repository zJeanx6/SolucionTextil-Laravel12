<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StateController;
use Illuminate\Support\Facades\Route;

Route::resource('sizes', SizeController::class);
Route::resource('roles', RoleController::class);
Route::resource('states', StateController::class);