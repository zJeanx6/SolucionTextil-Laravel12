<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class MachineController
 *
 * Gestiona las vistas relacionadas con máquinas y la creación de mantenimientos.
 *
 * - index():           Muestra la lista de máquinas.
 * - makemaintenance(): Muestra el formulario para registrar un nuevo mantenimiento.
 */
class MachineController extends Controller
{
    /**
     * Muestra la vista con el listado de máquinas disponibles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.machines.index');
    }

    /**
     * Muestra la vista para crear un nuevo registro de mantenimiento de máquina.
     *
     * @return \Illuminate\View\View
     */
    public function makemaintenance()
    {
        return view('admin.maintenance.makemaintenance');
    }
}
