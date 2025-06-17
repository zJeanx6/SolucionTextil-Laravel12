<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class BrandController
 *
 * Gestiona las operaciones CRUD para el modelo Brand:
 *  - index:    Lista paginada de marcas
 *  - create:   Muestra el formulario de creación
 *  - store:    Valida y guarda una nueva marca
 *  - edit:     Muestra el formulario de edición
 *  - update:   Valida y actualiza una marca existente
 *  - destroy:  Elimina una marca
 */
class BrandController extends Controller
{
    /**
     * Muestra una lista paginada de marcas ordenada por ID descendente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(12);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Muestra la vista para crear una nueva marca.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Valida y guarda una nueva marca en la base de datos.
     * - 'name': obligatorio, entre 3 y 100 caracteres, único en la tabla brands.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:100|unique:brands,name',
        ]);

        Brand::create($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Marca creada correctamente.');
    }

    /**
     * Muestra la vista de edición para la marca dada.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\View\View
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Valida y actualiza la marca existente.
     * - Usa Rule::unique()->ignore($brand->id) para permitir que el propio valor no falle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand         $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('brands', 'name')->ignore($brand->id),
            ],
        ]);

        $brand->update($data);

        return redirect()
            ->route('admin.brands.edit', $brand)
            ->with('success', 'Marca actualizada correctamente.');
    }

    /**
     * Elimina la marca de la base de datos.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Marca eliminada correctamente.');
    }
}
