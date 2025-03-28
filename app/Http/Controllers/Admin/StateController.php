<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\states;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = States::all();
        return view('admin.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(states $states)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(states $states)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, states $states)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(states $states)
    {
        //
    }
}
