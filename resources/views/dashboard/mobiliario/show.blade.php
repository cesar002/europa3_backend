@extends('layouts.app-admin')

@section('title')
	<title>Mobiliario - {{ $mobiliario->nombre }}</title>
@endsection

@section('body')

	<x-call-back-message />

	<div class="row my-3">
		<div class="col-6">
			<a href="{{ route('dashboard.mobiliario.index') }}"
				class="btn btn-primary"
			>
				Regresar
			</a>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12 px-5">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link active" href="{{ route('dashboard.mobiliario.show', ['id' => $mobiliario->id]) }}">
						Detalles/Edición
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('dashboard.mobiliario.distribucion', ['id' => $mobiliario->id]) }}">
						Distribucción
					</a>
				</li>
			</ul>
			<div class="card">
				<form id="formUpdate" action="{{ route('dashboard.mobiliario.update', ['id' => $mobiliario->id]) }}" method="POST">
					@csrf
					<div class="card-body">
						<div class="form-row my-2">
							<div class="col-6">
								<label for="edificio">Edificio</label>
								<select name="edificio_id" id="edificio"
									class="form-control {{ $errors->has('edificio_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un edificio</option>
									@foreach ($edificios as $edificio)
										<option value="{{ $edificio->id }}" {{ $edificio->id == $mobiliario->edificio_id ? 'selected' : '' }}>
											{{ $edificio->nombre }}
										</option>
									@endforeach
								</select>
								@error('edificio_id')
									<x-invalid-feedback message='{{ $message }}'/>
								@enderror
							</div>
							<div class="col-6">
								<label for="tipo_id">Tipo de mueble</label>
								<select name="tipo_id" id="tipo_id"
									class="form-control {{ $errors->has('tipo_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un tipo de mueble</option>
									@foreach ($tiposMueble as $item)
										<option value="{{ $item->id }}" {{ $item->id == $mobiliario->tipo_id ? 'selected' : '' }}>
											{{ $item->tipo }}
										</option>
									@endforeach
								</select>
								@error('tipo_id')
									<x-invalid-feedback message='{{ $message }}'/>
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" name="nombre" id="nombre"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								value="{{ $mobiliario->nombre }}"
							>
							@error('nombre')
								<x-invalid-feedback message='{{ $message }}'/>
							@enderror
						</div>
						<div class="form-group">
							<label for="">Estado del mobiliario</label>
						</div>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="activo"
								name="activo"
								{{ $mobiliario->activo ? 'checked' : '' }}
							>
							<label for="activo">Activo</label>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-4">
								<label for="marca">Marca</label>
								<input type="text"
									id="marca"
									class="form-control"
									name="marca"
									value="{{ $mobiliario->marca }}"
								>
							</div>
							<div class="col-12 col-sm-4">
								<label for="modelo">Modelo</label>
								<input type="text"
									id="modelo"
									class="form-control"
									name="modelo"
									value="{{ $mobiliario->modelo }}"
								>
							</div>
							<div class="col-12 col-sm-4">
								<label for="color">Color</label>
								<input type="text"
									id="color"
									class="form-control"
									name="color"
									value="{{ $mobiliario->color }}"
								>
							</div>
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea name="descripcion" id="descripcion" rows="5"
								class="form-control"
							>
								{{ $mobiliario->descripcion }}
							</textarea>
						</div>
						<div class="form-group">
							<label for="observaciones">Observaciones</label>
							<textarea name="observaciones" id="observaciones" rows="5"
								class="form-control"
							>
								{{ $mobiliario->observaciones }}
							</textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="cantidad">Cantidad</label>
								<input type='number'
									id="cantidad"
									name="cantidad"
									value="{{ $mobiliario->cantidad }}"
									class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
								>
								@error('cantidad')
									<x-invalid-feedback message='{{ $message }}'/>
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12">
								<label for="">Imagen</label>
							</div>
							<div class="col-12">
								<img src="{{ Storage::url($mobiliario->getImage()) }}" alt="{{ $mobiliario->nombre }}" class="img-fluid"
									style="max-height: 250px"
								>
							</div>
						</div>
						<div class="form-row my-3">
							<input type='file' class="form-control-file" id="image" accept="image/*">
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-primary btn-block" id="btnSubmit">
							<x-spinner size='' id='spinner' />
							<span id="text">Guardar cambios</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('js')
	<script>
		$(document).ready(()=>{
			$('#spinner').hide();

			$('#formUpdate').submit(e => {
				$('#btnSubmit').attr('disabled', true)
				$('#spinner').show();
				$('#text').hide();
			})

		});
	</script>
@endpush
