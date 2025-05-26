<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index()
    {   
        $brands = Brand::orderBy('id', 'desc')->paginate(12);
        return view('admin.brands.index', compact('brands'));
    }


    public function create()
    {
        return view('admin.brands.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:100'
        ]);

        Brand::create($data);
        return redirect()->route('admin.brands.index')->with('success', 'Marca creada correctamente.');
    }


    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }


    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:100'
        ]);

        $brand->update($data);
        return redirect()->route('admin.brands.edit', $brand)->with('success', 'Marca actualizada correctamente.');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Marca eliminada correctamente.');
    }
    
}
