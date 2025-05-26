<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TypeController extends Controller
{

    public function index()
    {
        return view('admin.types.index');
    }
    
}
