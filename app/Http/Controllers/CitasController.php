<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitasController extends Controller
{
    public function show()
    {
        return view('admin.filtrar.filtrar');
    }
}
