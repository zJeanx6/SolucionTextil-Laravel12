<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{

    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }


    public function create()
    {
        return view('admin.sizes.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'abbreviation' => 'required|min:1|max:10'
        ]);

        Size::create($data);
        return redirect()->route('admin.sizes.index')->with('success', 'Talla creada.');
    }


    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }


    public function update(Request $request, Size $size)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'abbreviation' => 'required|min:1|max:10'
        ]);

        $size->update($data);
        return redirect()->route('admin.sizes.index', $size)->with('success', 'Talla actualizada.');
    }


    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Talla eliminada.');
    }
    
}
