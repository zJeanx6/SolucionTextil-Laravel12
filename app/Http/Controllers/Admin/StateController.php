<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class StateController
 *
 * Gestiona las operaciones CRUD para el modelo State:
 *  - index:    Lista paginada de estados
 *  - create:   Muestra el formulario de creación
 *  - store:    Valida y guarda un nuevo estado
 *  - edit:     Muestra el formulario de edición
 *  - update:   Valida y actualiza un estado existente
 *  - destroy:  Elimina un estado
 */
class StateController extends Controller
{
    /**
     * Muestra una lista paginada de estados ordenada por ID ascendente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $states = State::orderBy('id', 'asc')->paginate(12);
        return view('admin.states.index', compact('states'));
    }

    /**
     * Muestra la vista para crear un nuevo estado.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.states.create');
    }

    /**
     * Valida y guarda un nuevo estado en la base de datos.
     * - 'name':        obligatorio, entre 3 y 100 caracteres, único en la tabla states.
     * - 'description': opcional, entre 10 y 255 caracteres.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|min:3|max:100|unique:states,name',
            'description' => 'nullable|string|min:10|max:255',
        ]);

        State::create($data);

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'Estado creado correctamente.');
    }

    /**
     * Muestra la vista de edición para el estado dado.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\View\View
     */
    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }

    /**
     * Valida y actualiza el estado existente en la base de datos.
     * - 'name':        obligatorio, entre 3 y 100 caracteres, único en states excepto el actual.
     * - 'description': opcional, entre 10 y 255 caracteres.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State         $state
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, State $state)
    {
        $data = $request->validate([
            'name'        => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('states', 'name')->ignore($state->id),
            ],
            'description' => 'nullable|string|min:10|max:255',
        ]);

        $state->update($data);

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Verifica si el estado tiene registros relacionados en otras tablas
     *
     * @param  \App\Models\State  $state
     * @return bool
     */
    private function hasRelatedData(State $state)
    {
        // Verificamos si el estado está siendo utilizado en productos, máquinas, etc.
        $hasProducts = DB::table('products')->where('state_id', $state->id)->exists();
        $hasMachines = DB::table('machines')->where('state_id', $state->id)->exists();
        $hasMachines = DB::table('users')->where('state_id', $state->id)->exists();

        // Si alguno de los registros existe, retornamos true
        return $hasProducts || $hasMachines;
    }

    /**
     * Elimina el estado de la base de datos.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(State $state)
    {
        // Verificamos si el estado tiene registros relacionados
        $hasRelatedData = $this->hasRelatedData($state);

        if ($hasRelatedData) {
            // Si tiene registros relacionados, mostramos un mensaje amigable
            return redirect()
                ->route('admin.states.index')
                ->with('success', 'No se puede eliminar el estado porque está relacionado con otros registros.');
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        $state->delete();

        // Redirigir y mostrar mensaje de éxito
        return redirect()
            ->route('admin.states.index')
            ->with('success', 'Estado eliminado correctamente.');
    }

}
