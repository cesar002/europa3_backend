@extends('layouts.app-admin')

@section('title')
	<title>Oficinas Virtuales</title>
@endsection

@section('body')
	<div class="row my-3">
		<div class="col-6">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newOficinaVirtual">
				Registrar oficina
			</button>
		</div>
	</div>

	@if ($errors->any())
		<x-alert-warning-message message='Verifique la información del formulario de registro' />
	@endif

	@livewire('oficinas-virtuales',[
		'oficinasVirtuales' => $oficinasVirtuales,
		'edificios' => $edificios,
	])

	<div class="modal fade" id="newOficinaVirtual" tabindex="-1" role="dialog" aria-labelledby="newOficinaVirtualTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newOficinaVirtualTitle">
						<strong>Nueva oficina virtual</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="formNew" action="{{ route('dashboard.oficinas-virtuales.store') }}" method="post">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="">Nombre</label>
							<input type="text"
								name="nombre"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
							>
							@error('nombre')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="edificio">Edificio</label>
							<select name="edificio_id" id="edificio"
								class="form-control {{ $errors->has('edificio_id') ? 'is-invalid' : '' }}"
							>
								<option value="">Seleccione un edificio</option>
								@foreach ($edificios as $item)
									<option value="{{ $item->id }}">{{ $item->nombre }}</option>
								@endforeach
							</select>
							@error('edificio_id')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea name="descripcion" id="descripcion" rows="4" class="form-control"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="precio">Precio</label>
								<input type="text" name="precio" id="precio"
									class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}"
								>
								@error('precio')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button id="btnCancelar" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
		$(document).ready(() => {
			$('#spinner').hide();
			$('#formNew').submit(e => {
				$('#btnCancelar').attr('disabled', true);
				$('#btnSubmit').attr('disabled', true);
				$('#text').hide();
				$('#spinner').show();
			})
		})
	</script>
@endpush
