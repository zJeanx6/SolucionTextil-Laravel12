<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(){
        $sizes = Size::orderBy('id', 'asc')->paginate(12);
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create(){
        return view('admin.sizes.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|min:3|max:100',
            'abbreviation' => 'required|min:3|max:25'
        ]);

        Size::create($data);
        return redirect()->route('admin.sizes.index')->with('success', 'Talla creada correctamente.');
    }

    public function show(Size $sizes){
        //
    }

    public function edit(Size $size){
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size){
        $data = $request->validate([
            'name' => 'required|min:3|max:100',
            'abbreviation' => 'required|min:3|max:25'
        ]);

        $size->update($data);
        return redirect()->route('admin.sizes.index', $size)->with('success', 'Talla actualizada correctamente.');
    }

    public function destroy(Size $size){
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Talla eliminada correctamente.');
    }
}
