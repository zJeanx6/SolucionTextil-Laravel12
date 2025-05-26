<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MachineController extends Controller
{

    public function index()
    {
        return view('admin.machines.index');
    }
    
}
