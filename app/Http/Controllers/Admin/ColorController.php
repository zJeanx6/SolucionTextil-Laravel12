<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('id', 'desc')->paginate(12);
        return view('admin.colors.index', compact('colors'));
    }


    public function create()
    {
        return view('admin.colors.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|size:6',
            'name' => 'required|min:3|max:20'
        ]);

        //$data['code'] = '#' . $data['code'];
        Color::create($data);
        return redirect()->route('admin.colors.index')->with('success', 'Color creado correctamente.');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }


    public function update(Request $request, Color $color)
    {
        $data = $request->validate([
            'code' => 'required|size:6',
            'name' => 'required|min:3|max:20'
        ]);

        $color->update($data);
        return redirect()->route('admin.colors.index', $color)->with('success', 'Color actualizado correctamente.');
    }


    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color eliminado correctamente.');
    }
}
