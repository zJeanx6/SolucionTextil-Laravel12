<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(){
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create(){
        //
    }

    public function store(Request $request){
        //
    }

    public function show(Size $sizes){
        //
    }

    public function edit(Size $sizes){
        //
    }

    public function update(Request $request, Size $sizes){
        //
    }

    public function destroy(Size $sizes){
        //
    }
}
