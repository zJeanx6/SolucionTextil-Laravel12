<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\MachineType;

/**
 * Class InventoryController
 *
 * Gestiona las vistas relacionadas con el inventario de elementos y productos,
 * así como sus movimientos. No interactúa directamente con el modelo, simplemente
 * retorna las vistas correspondientes.
 *
 * - elements():            Muestra la lista de elementos.
 * - elementsMovements():   Muestra los movimientos de elementos.
 * - products():            Muestra la lista de productos.
 * - productsMovements():   Muestra los movimientos de productos.
 */
class InventoryController extends Controller
{
    /**
     * Muestra la vista con el listado de elementos en inventario.
     *
     * @return \Illuminate\View\View
     */
    public function elements()
    {
        return view('admin.elements.index');
    }

    /**
     * Muestra la vista con el historial de movimientos de elementos.
     *
     * @return \Illuminate\View\View
     */
    public function elementsMovements()
    {
        return view('admin.elements.movements');
    }
    
    /**
     * Muestra la vista con el listado de productos en inventario.
     *
     * @return \Illuminate\View\View
     */
    public function products()
    {
        return view('admin.products.index');
    }

    /**
     * Muestra la vista con el historial de movimientos de productos.
     *
     * @return \Illuminate\View\View
     */
    public function productsMovements()
    {
        return view('admin.products.movements');
    }
}
