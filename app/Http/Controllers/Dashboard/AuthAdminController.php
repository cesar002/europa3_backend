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

		return view('dashboard.login');
	}

	public function login(LoginUserAdminRequest $request)
	{
		try{
			if(Auth::guard('admin')->attemp($request->only('username', 'password'), true)){
				return redirect()->route('dashboard.inicio');
			}

			session()->flash('', '');

			return redirect()->back();
		}catch(\Throwable $th){
			Log::error($th->getMessage());
			session()->flash('', '');

			return redirect()->back();
		}
	}
}
