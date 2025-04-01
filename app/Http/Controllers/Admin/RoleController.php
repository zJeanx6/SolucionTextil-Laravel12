<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::orderBy('id', 'desc')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:255',
        ]);

        $rol = new Role();
        $rol->name = $request->input('name');
        $rol->description = $request->input('description');
        $rol->save();

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(string $id)
    {
        $rol = Role::findOrFail($id);
        return view('admin.roles.show', compact('rol'));
    }

    public function edit(request $roles)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(request $roles)
    {
        //
    }
}
