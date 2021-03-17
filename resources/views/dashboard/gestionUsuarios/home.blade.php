@extends('layouts.app-admin')

@section('title')
	<title>Gestión de usuarios</title>
@endsection

@section('body')
	<div class="row my-3">
		<div class="col-6">
			<button class="btn btn-primary"
				type="button"
				data-toggle='modal'
				data-target='#newUsuario'
			>
				Registrar nuevo usuario
			</button>
		</div>
	</div>

	@if ($errors->any())
		<x-alert-warning-message message='Verifique la información de registro de nuevo usuario' />
	@endif

	<div class="row my-3">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Usuarios del sistema</strong>
					</h3>
				</div>
				<div class="card-body">
					@livewire('gestion-usuarios',[
						'usuarios' => $usuarios
					])
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="newUsuario" tabindex="-1" role="dialog" aria-labelledby="newUsuarioLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newUsuarioLabel">
						<strong>Nuevo usuario</strong>
					</h5>
					<button type="button" class="close" data-dismiss='modal' aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{ route('dashboard.gestion-usuario.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="username">Nombre de usuario</label>
							<input type="text"
								id="username"
								value="{{ old('username') }}"
								name="username"
								class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
							>
							@error('username')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="password">Contraseña</label>
								<input type="password"
									id="password"
									name="password"
									class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
								>
								@error('password')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="password_confirmation">Confirmar contraseña</label>
								<input type="password"
									id="password_confirmation"
									name="password_confirmation"
									class="form-control"
								>
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								name="nombre"
								id="nombre"
								value="{{ old('nombre') }}"
							>
							@error('nombre')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="ap_p">Apellido paterno</label>
							<input type="text"
								name="ap_p"
								class="form-control {{ $errors->has('ap_p') ?  'is-invalid' : '' }}"
								id="ap_p"
								value="{{ old('ap_p') }}"
							>
							@error('ap_p')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="ap_m">Apellido materno</label>
							<input type="text"
								id="ap_m"
								class="form-control {{ $errors->has('ap_m') ? 'is-invalid' : '' }}"
								name="ap_m"
								value="{{ old('ap_m') }}"
							>
							@error('ap_m')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="avatar">Imagen de perfil (opcional)</label>
							<input type="file"
								class="form-control-file"
								name="avatar"
								id="avatar"
								accept="image/*"
							>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@livewireScripts
@endsection
