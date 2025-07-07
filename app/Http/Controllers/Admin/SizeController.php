<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class SizeController
 *
 * Gestiona las operaciones CRUD para el modelo Size:
 *  - index:    Lista todas las tallas
 *  - create:   Muestra el formulario de creación
 *  - store:    Valida y guarda una nueva talla
 *  - edit:     Muestra el formulario de edición
 *  - update:   Valida y actualiza una talla existente
 *  - destroy:  Elimina una talla
 */
class SizeController extends Controller
{
    /**
     * Muestra todas las tallas registradas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Muestra la vista para crear una nueva talla.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Valida y guarda una nueva talla en la base de datos.
     * - 'name':         obligatorio, entre 3 y 50 caracteres, único en la tabla sizes.
     * - 'abbreviation': obligatorio, entre 1 y 10 caracteres, único en la tabla sizes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|min:3|max:50|unique:sizes,name',
            'abbreviation' => 'required|string|min:1|max:10|unique:sizes,abbreviation',
        ]);

        Size::create($data);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Talla creada correctamente.');
    }

    /**
     * Muestra la vista de edición para la talla dada.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\View\View
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Valida y actualiza la talla existente en la base de datos.
     * - Usa Rule::unique()->ignore($size->id) para permitir mantener el propio valor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size          $size
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Size $size)
    {
        $data = $request->validate([
            'name'         => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('sizes', 'name')->ignore($size->id),
            ],
            'abbreviation' => [
                'required',
                'string',
                'min:1',
                'max:10',
                Rule::unique('sizes', 'abbreviation')->ignore($size->id),
            ],
        ]);

        $size->update($data);

        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Talla actualizada correctamente.');
    }

    /**
     * Verifica si la talla tiene registros relacionados en otras tablas
     *
     * @param  \App\Models\Size  $size
     * @return bool
     */
    private function hasRelatedData(Size $size)
    {
        // Verificamos si la talla está siendo utilizada en productos, o cualquier otro modelo que use talla
        $hasProducts = DB::table('products')->where('size_id', $size->id)->exists();

        // Si algún registro está relacionado con la talla, retornamos true
        return $hasProducts;
    }

    /**
     * Elimina la talla de la base de datos.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Size $size)
    {
        // Verificamos si la talla tiene registros relacionados
        $hasRelatedData = $this->hasRelatedData($size);

        if ($hasRelatedData) {
            // Si tiene registros relacionados, mostramos un mensaje amigable
            return redirect()
                ->route('admin.sizes.index')
                ->with('success', 'No se puede eliminar la talla porque está relacionada con productos u otros registros.');
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        $size->delete();

        // Redirigir y mostrar mensaje de éxito
        return redirect()
            ->route('admin.sizes.index')
            ->with('success', 'Talla eliminada correctamente.');
    }
}
