<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TypeMaintenanceController extends Controller
{

    public function index()
    {
        return view('admin.maintenance.index');
    }

}
