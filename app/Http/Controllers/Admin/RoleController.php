<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class RoleController
 *
 * Gestiona las operaciones CRUD para el modelo Role:
 *  - index:    Lista paginada de roles
 *  - create:   Muestra el formulario de creación
 *  - store:    Valida y guarda un nuevo rol
 *  - edit:     Muestra el formulario de edición
 *  - update:   Valida y actualiza un rol existente
 *  - destroy:  Elimina un rol
 */
class RoleController extends Controller
{
    /**
     * Muestra una lista paginada de roles ordenada por ID descendente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->paginate(12);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Muestra la vista para crear un nuevo rol.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Valida y guarda un nuevo rol en la base de datos.
     * - 'name':        obligatorio, entre 3 y 255 caracteres, único en la tabla roles.
     * - 'description': obligatorio, entre 10 y 255 caracteres.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:3|max:255|unique:roles,name',
            'description' => 'required|string|min:10|max:255',
        ]);

        Role::create($data);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    /**
     * Muestra la vista de edición para el rol dado.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Valida y actualiza el rol existente en la base de datos.
     * - 'name':        obligatorio, entre 3 y 255 caracteres, único en roles excepto el actual.
     * - 'description': obligatorio, entre 10 y 255 caracteres.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role          $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'        => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'description' => 'required|string|min:10|max:255',
        ]);

        $role->update($data);

        return redirect()
            ->route('admin.roles.edit', $role)
            ->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Elimina el rol de la base de datos.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}
