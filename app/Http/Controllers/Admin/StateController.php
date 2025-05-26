<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('id', 'asc')->paginate(12);
        return view('admin.states.index', compact('states'));
    }


    public function create()
    {
        return view('admin.states.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'nullable|min:10|max:255',
        ]);

        State::create($data);
        return redirect()->route('admin.states.index')->with('success', 'Estado creado correctamente.');
    }


    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }


    public function update(Request $request, State $state)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:100'
        ]);

        $state->update($data);
        return redirect()->route('admin.states.index', $state)->with('success', 'Estado actualizado correctamente.');
    }


    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('admin.states.index')->with('success', 'Estado eliminado correctamente.');
    }
}
