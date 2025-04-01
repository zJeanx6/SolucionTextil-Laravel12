<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        $states = State::all();
        return view('admin.states.index', compact('states'));
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //
    }

    public function show(State $states){
        //
    }

    public function edit(State $states){
        //
    }

    public function update(Request $request, State $states){
        //
    }

    public function destroy(State $states){
        //
    }
}
