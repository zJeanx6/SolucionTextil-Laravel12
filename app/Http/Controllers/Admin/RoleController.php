<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::orderBy('id', 'desc')->paginate(8);
        return view('admin.roles.index', compact('roles'));
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:255',
        ]);
        Role::create($data);
        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Role $role){
    }

    public function edit(Role $role){
        return view('admin.roles.edit' , compact('role'));
    }

    public function update(Request $request, Role $role){
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:255',
        ]);
        $role->update($data);
        return redirect()->route('admin.roles.edit', $role)->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
