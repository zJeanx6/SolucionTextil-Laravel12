<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Machine, MachineType};

class InventoryController extends Controller
{
    public function elements()
    {
        return view('admin.elements.index');
    }

    public function elementsMovements()
    {
        return view('admin.elements.movements');
    }
    
    public function products()
    {
        return view('admin.products.index');
    }

    public function productsMovements()
    {
        return view('admin.products.movements');
    }
}
