<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::resource('sizes', SizeController::class);
Route::resource('roles', RoleController::class);
Route::resource('states', StateController::class);
Route::resource('marcas', BrandController::class)->parameter( 'marcas', 'brand')->names('brands');
Route::resource('colores', ColorController::class)->parameter( 'colores', 'color')->names('colors');
Route::resource('users', UsersController::class)->names('users');

Route::get('tipos', TypeManager::class)->name('types.index');