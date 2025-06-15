<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\TypeMaintenanceController;
use App\Livewire\ElementsMov;
use Illuminate\Support\Facades\Route;

// Grupo para admin con acceso total (recuerda que admin puede hacer todo)
Route::middleware('role:administrador')->group(function () {
    Route::resource('sizes', SizeController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('states', StateController::class);
    Route::resource('marcas', BrandController::class)->parameter('marcas', 'brand')->names('brands');
    Route::resource('colores', ColorController::class)->parameter('colores', 'color')->names('colors');
    Route::resource('users', UsersController::class)->names('users');
    Route::resource('types', TypeController::class)->parameter('tipos', 'type')->names('types');
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('maintenance', [TypeMaintenanceController::class, 'index'])->name('maintenance.index');
});

// Grupo para admin e inventory con acceso solo a productos y elementos
Route::middleware('role:administrador,inventario')->group(function () {
    Route::get('productos', [InventoryController::class, 'products'])->name('products.index');
    Route::get('elementos', [InventoryController::class, 'elements'])->name('elements.index');
    // Route::get('elementos/movimiento', [InventoryController::class, 'elementsMovements'])->name('elements.movements');
    Route::get('elementos/movimiento', ElementsMov::class)->name('elements.movements');
    Route::get('productos/movimiento', [InventoryController::class, 'productsMovements'])->name('products.movements');
    Route::view('dashboard-inventory', 'dashboard-inventory')->name('dashboard-inventory');
});

// Grupo para admin y maintenance con acceso solo a maintenance
Route::middleware('role:administrador,mantenimiento')->group(function () {
    Route::view('dashboard-maintenance', 'dashboard-maintenance')->name('dashboard-maintenance');
    Route::get('maquinas', [MachineController::class, 'index'])->name('machines.index');
    Route::get('mantenimiento', [MachineController::class, 'makemaintenance'])->name('maintenance.makemaintenance');
});