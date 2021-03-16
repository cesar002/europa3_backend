@extends('layouts.app-admin')

@section('title')
	<title>Adicionales</title>
@endsection

@section('body')

	<div class="row my-3">
		<div class="col-6">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newAdicional">
				Registrar adicional
			</button>
		</div>
	</div>

	@if ($errors->any())
		<x-alert-warning-message message='Verifique los datos para registrar el adicional' />
	@endif

	@livewire('adicionales', [
		'adicionales' => $adicionales,
		'edificios' => $edificios,
		'unidades' => $unidades,
	])

	<div class="modal fade" id="newAdicional" tabindex="-1" role="dialog" aria-labelledby="newAdicionalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newAdicionalLabel">
						<strong>Nuevo adicional</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="{{ route('dashboard.adicionales.store') }}" id="formAdicional" method="POST">
					@csrf
					<div class="modal-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="edificio">Edificio</label>
								<select name="edificio_id" id="edificio"
									class="form-control {{ $errors->has('edificio_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Selecciona un edificio</option>
									@foreach ($edificios as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
									@endforeach
								</select>
								@error('edificio_id')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="unidad">Tipo de unidad</label>
								<select name="unidad_id" id="unidad"
									class="form-control {{ $errors->has('unidad_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Selecciona una unidad</option>
									@foreach ($unidades as $item)
										<option value="{{$item->id}}">{{ $item->unidad }}</option>
									@endforeach
								</select>
								@error('unidad_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" name="nombre" id="nombre"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								value="{{ old('nombre') }}"
							>
							@error('nombre')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea name="descripcion" id="descripcion" class="form-control" rows="5"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="cantidad_maxima">Cantidad máxima para comprar</label>
								<input type="number" id="cantidad_maxima"
									class="form-control {{ $errors->has('cantidad_maxima') ? 'is-invalid' : '' }}"
									name="cantidad_maxima"
									value="{{old('cantidad_maxima')}}"
								>
								@error('cantidad_maxima')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="precio">Precio</label>
								<input type="number"
									id='precio'
									name="precio"
									class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}"
									value="{{old('precio')}}"
								>
								@error('precio')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button id="btnCerrar" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button id="btnSubmit" type="submit" class="btn btn-primary">
							<x-spinner id='spinner' />
							<span id="text">Registrar</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@livewireScripts
@endsection

@push('js')
	<script>
		$(document).ready(()=>{
			$('#spinner').hide();
			$('#formAdicional').submit(e=>{
				$('#btnCerrar').attr('disabled', true)
				$('#btnSubmit').attr('disabled', true)
				$('#spinner').show();
				$('#text').hide();
			})
		});
	</script>
@endpush
