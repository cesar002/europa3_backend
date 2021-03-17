@extends('layouts.app-admin-login')

@section('title')
	<title>Bienvenido</title>
@endsection

@section('body')
	<div class="row my-4">
		<div class="col-lg-6 d-none d-lg-block bg-login-image">

		</div>
		<div class="col-lg-6">
			<div class="p-5">
				<div class="text-center">
					<h4 class="h4 text-gray-900 mb-4">
						Benvenido
					</h4>
				</div>
				<form action="{{ route('dashboard.login') }}" class="user" method="POST">
					@csrf
					<div class="form-group">
						<input type="text" class="form-control form-control-user {{ $errors->has('username') ? 'is-invalid' : '' }}"
							id="username" aria-describedby="username" placeholder="Nombre de usuario"
							name="username"
							value="{{ old('username') }}"
						>
						@error('username')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<input type="password" name="password" id="password"
							class="form-control form-control-user {{ $errors->has('password') ? 'is-invalid' : '' }}"
							placeholder="Contraseña"
						>
						@error('password')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					@if (session()->has('LOGIN_DATOS'))
						<div class="my-3">
							<span class="text-danger">{{ session('LOGIN_DATOS') }}</span>
						</div>
					@endif
					@if (session()->has('LOGIN_ERROR'))
						<div class="my-3">
							<span class="text-danger">{{ session('LOGIN_ERROR') }}</span>
						</div>
					@endif
					<button class="btn btn-primary btn-user btn-block">
						<strong>Iniciar sesión</strong>
					</button>
				</form>
			</div>
		</div>
	</div>
@endsection
