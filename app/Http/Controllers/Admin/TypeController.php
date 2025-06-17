<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TypeController extends Controller
{

    public function indexTypeCategories()
    {
        return view('admin.types.index');
    }

    public function indexTypeMaintenance()
    {
        return view('admin.maintenance.index');
    }

    public function indexProviders()
    {
        return view('admin.suppliers.index');
    }
    
}
