<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthAdminController extends Controller
{
    public function index()
	{

		if(Auth::guard('admin')->check()){
			return redirect()->route('dashboard.inicio');
		}

		return view('dashboard.login');
	}

	public function logout(Request $request)
	{
		try{
			Auth::guard('admin')->logout();

			return redirect()->route('dashboard.login-view');
		}catch(\Throwable $th){
			Log::error($th->getMessage());

			return redirect()->back();
		}
	}

	public function login(LoginUserAdminRequest $request)
	{
		try{
			if(Auth::guard('admin')->attempt($request->only('username', 'password'), true)){
				return redirect()->route('dashboard.inicio');
			}

			session()->flash('LOGIN_DATOS', 'Datos de inicio de sesión incorrectos');

			return redirect()->back();
		}catch(\Throwable $th){
			Log::error($th->getMessage());

			session()->flash('LOGIN_ERROR', 'Ocurrió un error al iniciar sesión');

			return redirect()->back();
		}
	}
}
