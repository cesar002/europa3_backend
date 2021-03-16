<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
	{
		return view('dashboard.inicio');
	}

	public function temp()
	{
		return redirect()->route('dashboard.inicio');
	}
}
