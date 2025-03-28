<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\sizes;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Sizes::all();
        return view('admin.sizes.index', compact('sizes'));
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
    public function show(sizes $sizes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sizes $sizes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sizes $sizes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sizes $sizes)
    {
        //
    }
}
