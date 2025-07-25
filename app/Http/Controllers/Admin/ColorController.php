<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Class ColorController
 *
 * Gestiona las operaciones CRUD para el modelo Color:
 *  - index:    Lista paginada de colores
 *  - create:   Muestra el formulario de creación
 *  - store:    Valida y guarda un nuevo color
 *  - edit:     Muestra el formulario de edición
 *  - update:   Valida y actualiza un color existente
 *  - destroy:  Elimina un color
 */
class ColorController extends Controller
{
    /**
     * Muestra una lista paginada de colores ordenada por ID descendente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->paginate(12);
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Muestra la vista para crear un nuevo color.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Valida y guarda un nuevo color en la base de datos.
     * - 'code': obligatorio, 6 caracteres, único en la tabla colors.
     * - 'name': obligatorio, entre 3 y 20 caracteres, único en la tabla colors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|size:6|unique:colors,code',
            'name' => 'required|min:3|max:20|unique:colors,name',
        ]);

        Color::create($data);

        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'Color creado correctamente.');
    }

    /**
     * Muestra la vista de edición para el color dado.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\View\View
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Valida y actualiza el color existente.
     * - Usa Rule::unique()->ignore($color->id) para permitir que el propio valor no falle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color         $color
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'code' => [
                'required',
                'size:6',
                Rule::unique('colors', 'code')->ignore($color->id),
            ],
            'name' => [
                'required',
                'min:3',
                'max:20',
                Rule::unique('colors', 'name')->ignore($color->id),
            ],
        ]);

        $color->update($data);

        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'Color actualizado correctamente.');
    }

    /**
     * Verifica si el color tiene registros relacionados en otras tablas
     *
     * @param  \App\Models\Color  $color
     * @return bool
     */
    private function hasRelatedData(Color $color)
    {
        // Verificamos si el color está siendo utilizado por algún producto o elemento
        $hasProducts = DB::table('products')->where('color_id', $color->id)->exists();
        $hasElements = DB::table('elements')->where('color_id', $color->id)->exists();

        // Si el color está relacionado con productos o elementos, retornamos true
        return $hasProducts || $hasElements;
    }

    /**
     * Elimina el color de la base de datos.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Color $color)
    {
        // Verificamos si el color tiene registros relacionados
        $hasRelatedData = $this->hasRelatedData($color);

        if ($hasRelatedData) {
            // Si tiene registros relacionados, mostramos un mensaje amigable
            return redirect()
                ->route('admin.colors.index')
                ->with('success', 'No se puede eliminar el color porque está relacionado con productos o elementos.');
        }

        // Si no tiene datos relacionados, proceder con la eliminación
        $color->delete();

        // Redirigir y mostrar mensaje de éxito
        return redirect()
            ->route('admin.colors.index')
            ->with('success', 'Color eliminado correctamente.');
    }
}
