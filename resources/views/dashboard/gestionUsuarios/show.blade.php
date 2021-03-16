@extends('layouts.app-admin')

@section('title')
	<title>Usuario - {{ $usuario->username }}</title>
@endsection

@section('body')

	<div class="row my-3">
		<div class="col-6">
			<a href="{{ route('dashboard.gestion-usuario.index') }}" class="btn btn-primary">
				Regresar
			</a>
		</div>
	</div>

	<x-call-back-message />

	@if ($errors->any())
		<p>asdasd</p>
	@endif

	<div class="row my-5">
		<div class="col-12 px-0 px-sm-5">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link active" href="{{ route('dashboard.gestion-usuario.show', ['id' => $usuario->id]) }}">
						Detalles / Edición
					</a>
				</li>
				{{-- <li class="nav-item">
					<a class="nav-link" href="">Cambio de contraseña</a>
				</li> --}}
			</ul>
			<div class="card">
				<form action="{{ route('dashboard.gestion-usuario.update', ['id' => $usuario->id]) }}" method="POST" enctype="multipart/form-data" class="px-0 px-sm-5">
					@csrf
					<div class="card-body">
						<input type="hidden" name="user_id" value="{{ $usuario->id }}">
						<div class="form-group">
							<label for="username">Nombre de usuario</label>
							<input type="text"
								id="username"
								value="{{ $usuario->username }}"
								class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
								name="username"
							>
							@error('username')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form group">
							<label for="nombre">Nombre</label>
							<input type="text"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : ''}}"
								value="{{ $usuario->infoPersonal->nombre }}"
								name="nombre"
								id="nombre"
							>
							@error('nombre')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form group">
							<label for="ap_p">Apellido paterno</label>
							<input type="text"
								id="ap_p"
								class="form-control {{ $errors->has('ap_p') ? 'is-invalid' : ''}}"
								name="ap_p"
								value="{{ $usuario->infoPersonal->ap_p }}"
							>
							@error('ap_p')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form group">
							<label for="ap_m">Apellido materno</label>
							<input type="text"
								id="ap_m"
								class="form-control {{ $errors->has('ap_m') ? 'is-invalid' : ''}}"
								value="{{ $usuario->infoPersonal->ap_m }}"
								name="ap_m"
							>
							@error('ap_m')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-row my-5">
							<div class="col-12">
								@if ($usuario->getAvatar() != null)
									<img src="{{ $usuario->getAvatar() }}" alt="{{ $usuario->username }}"
										class="img-fluid"
										style="max-height: 200px; max-width: 200px;"
									>
								@endif
							</div>
							<div class="col-12 col-sm-6">
								<label for="avatar">Avatar</label>
								<input type="file"
									id="avatar"
									class="form-control-file {{ $errors->has('avatar') ? 'is-invalid' : '' }}"
									name="avatar"
								>
								@error('avatar')
								<x-invalid-feedback :message='$message' />
							@enderror
							</div>
						</div>
					</div>
					<div class="card-footer px-0 px-sm-5">
						<button class="btn btn-primary btn-block" type="submit">
							Guardar cambios
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection
