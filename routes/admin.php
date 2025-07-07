<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\MachineController;
use Illuminate\Support\Facades\Route;

// Grupo para admin con acceso total (recuerda que admin puede hacer todo)
Route::middleware('role:superadmin', 'checkExpiredLicenses')->group(function () {
    Route::view('sa.dashboard-sa', 'sa.dashboard-sa')->name('sa.dashboard-sa');
    Route::view('sa.company-sa', 'sa.company-sa')->name('sa.company-sa');
    Route::view('sa.type-sa', 'sa.type-sa')->name('sa.type-sa');
    Route::view('sa.license-sa', 'sa.license-sa')->name('sa.license-sa');
    Route::view('sa.user-sa', 'sa.user-sa')->name('sa.user-sa');
});

Route::middleware('role:administrador', 'checkExpiredLicenses')->group(function () {
    Route::resource('tallas', SizeController::class)->parameter('tallas', 'size')->names('sizes');
    Route::resource('roles', RoleController::class)->parameter('roles', 'role')->names('roles');
    Route::resource('estados', StateController::class)->parameter('estados', 'state')->names('states');
    Route::resource('marcas', BrandController::class)->parameter('marcas', 'brand')->names('brands');
    Route::resource('colores', ColorController::class)->parameter('colores', 'color')->names('colors');
    Route::resource('usuarios', UsersController::class)->parameter('usuarios', 'user')->names('users');
    Route::get('tipos', [TypeController::class, 'indexTypeCategories'])->name('types.index');
    Route::get('proveedores', [TypeController::class, 'indexProviders'])->name('suppliers.index');
    Route::get('mantenimientos', [TypeController::class, 'indexTypeMaintenance'])->name('maintenance.index');
    Route::view('dashboard-report', 'dashboard-report')->name('dashboard.reportes');
    Route::view('dashboard-inventory', 'dashboard-inventory')->name('dashboard-inventory');
});

// Grupo para admin e inventory con acceso solo a productos y elementos
Route::middleware('role:administrador,inventario', 'checkExpiredLicenses')->group(function () {
    Route::get('productos', [InventoryController::class, 'products'])->name('products.index');
    Route::get('elementos', [InventoryController::class, 'elements'])->name('elements.index');
    Route::get('elementos/movimiento', [InventoryController::class, 'elementsMovements'])->name('elements.movements');
    Route::get('productos/movimiento', [InventoryController::class, 'productsMovements'])->name('products.movements');
});

// Grupo para admin y maintenance con acceso solo a maintenance
Route::middleware('role:administrador,mantenimiento', 'checkExpiredLicenses')->group(function () {
    Route::view('dashboard-maintenance', 'dashboard-maintenance')->name('dashboard-maintenance');
    Route::get('maquinas', [MachineController::class, 'index'])->name('machines.index');
    Route::get('mantenimiento', [MachineController::class, 'makemaintenance'])->name('maintenance.makemaintenance');
});