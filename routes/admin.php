<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
use App\Livewire\TypeManager;
use Illuminate\Support\Facades\Route;

Route::resource('sizes', SizeController::class);
Route::resource('roles', RoleController::class);
Route::resource('states', StateController::class);
Route::resource('marcas', BrandController::class)->parameter( 'marcas', 'brand')->names('brands');
Route::resource('colores', ColorController::class)->parameter( 'colores', 'color')->names('colors');
Route::resource('users', UsersController::class)->names('users');

Route::get('productos', [InventoryController::class, 'products'])->name('products.index');
Route::get('elementos', [InventoryController::class, 'elements'])->name('elements.index');
Route::get('maquinas', [InventoryController::class, 'machines'])->name('machines.index');

Route::get('tipos', TypeManager::class)->name('types.index');