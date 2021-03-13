@extends('layouts.app-admin')

@section('title')
	<title>Mobiliario</title>
@endsection

@section('body')

	@if ($errors->any())
		<x-alert-warning-message message='Verifique los para registrar el mobiliario' />
	@endif

	<x-call-back-message />

	<div class="row my-3">
		<div class="col-6">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newMobiliario">
				Agregar nuevo mobiliario
			</button>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><strong>Mobiliario</strong></h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Color</th>
									<th>Descripción</th>
									<th>Fotografía</th>
									<th>Edificio</th>
									<th>Cantidad</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($mobiliario as $mob)
									<tr>
										<td>{{ $mob->nombre }}</td>
										<td>{{ $mob->marca }}</td>
										<td>{{ $mob->modelo }}</td>
										<td>{{ $mob->color }}</td>
										<td>{{ $mob->descripcion }}</td>
										<td>
											<img src="{{ Storage::url($mob->getImage()) }}"
												class="img-fluid"
												style="max-height: 100px"
											>
										</td>
										<td>{{ $mob->edificio->nombre }}</td>
										<td>{{ $mob->cantidad }}</td>
										<td>
											<a class="btn btn-primary btn-sm"
												href="{{ route('dashboard.mobiliario.show', ['id' => $mob->id]) }}"
											>
												<i class="fa fa-pencil-alt"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="newMobiliario" tabindex="-1" role="dialog" aria-labelledby="newMobiliarioLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newMobiliarioLabel">
						<strong>Nuevo mobiliario</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formNewMobiliario" action="{{ route('dashboard.mobiliario.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="edificio">Edificio</label>
								<select name="edificio_id" id="edificio"
									class="form-control {{ $errors->has('edificio_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un edificio</option>
									@foreach ($edificios as $edificio)
										<option value="{{ $edificio->id }}" {{ $edificio->id == old('edificio_id') ? 'selected' : ''}}>
											{{ $edificio->nombre }}
										</option>
									@endforeach
								</select>
								@error('edificio_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="tipo_mueble">Tipo de mueble</label>
								<select name="tipo_mueble_id" id="tipo_mueble"
									class="form-control {{ $errors->has('tipo_mueble_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un tipo de mueble</option>
									@foreach ($tiposMueble as $tipo)
										<option value="{{ $tipo->id }}" {{ $tipo->id == old('tipo_mueble_id') ? 'selected' : '' }}>
											{{ $tipo->tipo }}
										</option>
									@endforeach
								</select>
								@error('tipo_mueble_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre del mueble</label>
							<input type="text"
								id='nombre'
								name="nombre"
								value="{{ old('nombre') }}"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
							>
							@error('nombre')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="marca">Marca</label>
								<input type="text"
									name="marca" id="marca"
									class="form-control"
									value="{{ old('marca') }}"
								>
							</div>
							<div class="col-4">
								<label for="modelo">Modelo</label>
								<input type="text" name="modelo" id="modelo"
									class="form-control"
									value="{{ old('modelo') }}"
								>
							</div>
							<div class="col-4">
								<label for="color">Color</label>
								<input type="text" name="color" id="color"
									class="form-control"
									value="{{ old('color') }}"
								>
							</div>
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea class='form-control' name="descripcion" id="descripcion" rows="5"></textarea>
						</div>
						<div class="form-group">
							<label for="observacion">Observaciones</label>
							<textarea class='form-control' name="observaciones" id="observacion" rows="5"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="">Cantidad</label>
								<input type="number" name="cantidad" id="cantidad"
									class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
									value="{{ old('cantidad') }}"
								>
								@error('cantidad')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="image">Subir imagen</label>
							<input type='file' class="form-control-file" id="image" accept="image/*"
								name="image"
							>
							@error('image')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="btnCerrar" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" id="btnSubmit">
							<x-spinner id='spinner' />
							<span id="text">Registrar</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('js')
	<script>
		$(document).ready(() => {

			$('#spinner').hide();

			$('#formNewMobiliario').submit(e => {
				$('#btnSubmit').attr('disabled', true);
				$('#btnCerrar').attr('disabled', true);
				$('#text').hide();
				$('#spinner').show();
			})
		});
	</script>
@endpush
