<div>

	<form wire:submit.prevent='update'>
		@csrf
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<label for="edificio_id">Edificio</label>
				<select wire:model='oficina.edificio_id' id="edificio_id"
					class="form-control {{$errors->has('oficina.edificio_id') ? 'is-invalid' : ''}}"
					wire:change='fetchMobiliario'
				>
					<option value="">Seleccione un edificio</option>
					@foreach ($edificios as $item)
						<option value="{{ $item->id }}">{{ $item->nombre }}</option>
					@endforeach
				</select>
				@error('oficina.edificio_id')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<label for="size_id">Tamaño de oficina</label>
				<select id="size_id"
					class="form-control {{$errors->has('oficina.size_id') ? 'is-invalid' : ''}}"
					wire:model='oficina.size_id'
				>
					<option value="">Selecciona un tamaño</option>
					@foreach ($sizes as $item)
						<option value="{{$item->id}}">{{ $item->size_name }}</option>
					@endforeach
				</select>
				@error('oficina.size_id')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
		</div>
		<div class="form-group">
			<label for="nombre">Nombre</label>
			<input type="text" class="form-control {{ $errors->has('oficina.nombre') ? 'is-invalid' : '' }}"
				wire:model='oficina.nombre'
				id="nombre"
			>
			@error('oficina.nombre')
				<x-invalid-feedback message='{{$message}}' />
			@enderror
		</div>
		<div class="form-group">
			<label for="descripcion">Descripción</label>
			<textarea wire:model='oficina.descripcion'id="descripcion" class="form-control" rows="5"></textarea>
		</div>
		<div class="form-row my-2">
			<div class="col-6">
				<label for="dimensiones">Dimensiones de la oficina</label>
				<input type="text" class="form-control {{ $errors->has('oficina.size_dimension') ? 'is-invalid' : '' }}"
					wire:model='oficina.size_dimension'
					id="dimensiones"
				>
				@error('oficina.size_dimension')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
		</div>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<label for="capacidad_recomendada">Capacidad recomendada</label>
				<input type="text"
					id="capacidad_recomendada"
					wire:model='oficina.capacidad_recomendada'
					class="form-control {{$errors->has('oficina.capacidad_recomendada') ? 'is-invalid' : ''}}"
				>
				@error('oficina.capacidad_recomendada')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<label for="capacidad_maxima">Capacidad máxima</label>
				<input type="text"
					id="capacidad_maxima"
					wire:model='oficina.capacidad_maxima'
					class="form-control {{ $errors->has('oficina.capacidad_maxima') ? 'is-invalid' : '' }}"
				>
				@error('oficina.capacidad_maxima')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
		</div>
		<div class="form-row my-2">
			<div class="col-4">
				<label for="precio">Precio</label>
				<input type="text"
					id="precio"
					wire:model='oficina.precio'
					class="form-control {{$errors->has('oficina.precio') ? 'is-invalid' : ''}}"
				>
				@error('oficina.precio')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
		</div>
		<div class="form-group">
			<label for="">Servicios</label>
		</div>
		<div class="form-row">
			<div class="col-12 col-sm-6">
				<select
					class="form-control {{ $errors->has('oficina.servicios') ? 'is-invalid' : '' }}"
					wire:model='servicio_selected'
				>
					<option value="">Elija un servicio</option>
					@foreach ($servicios as $item)
						<option value="{{$item->id}}">{{ $item->servicio }}</option>
					@endforeach
				</select>
				@error('oficina.servicios')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
			<div class="col-12 col-sm-4">
				<button class="btn btn-primary btn-sm mt-3 mt-sm-0" type="button"
					wire:click='addServicios'
				>
					Agregar
				</button>
			</div>
			<div class="col-12">
				<table class="table">
					<thead>
						<tr>
							<th>Servicio</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($oficina['servicios'] as $i => $item)
							<tr>
								<td>{{$item['servicio']}}</td>
								<td>
									<button class="btn btn-danger btn-sm"
										type="button"
										wire:click='removeServicio({{ $i }})'
									>
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group">
			<label for="">Mobiliario</label>
		</div>
		<div class="form-row">
			<div class="col-12 col-sm-6">
				<select
					class="form-control {{ $errors->has('oficina.mobiliario_asignado') ? 'is-invalid' : '' }}"
					wire:model='mobiliario_selected'
				>
					<option value="">Elija un mobiliario</option>
					@foreach ($mobiliario as $item)
						<option value="{{$item->id}}">{{ $item->nombre }}</option>
					@endforeach
				</select>
				@error('oficina.mobiliario_asignado')
					<x-invalid-feedback message='{{$message}}' />
				@enderror
			</div>
			<div class="col-12 col-sm-4 mt-3 mt-sm-0">
				<button class="btn btn-primary btn-sm" type="button"
					wire:click='addMobiliario'
				>
					Agregar
				</button>
			</div>
			<div class="col-12">
				<table class="table">
					<thead>
						<tr>
							<th>Mobiliario</th>
							<th>Cantidad</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($oficina['mobiliario_asignado'] as $i => $item)
							<tr>
								<td>{{$item['mobiliario']['nombre']}}</td>
								<td>
									<input type="text"
										class="form-control w-25"
										wire:model="oficina.mobiliario_asignado.{{$i}}.cantidad"
									>
								</td>
								<td>
									<button class="btn btn-danger btn-sm"
										type="button"
										wire:click='removeMobiliario({{$i}})'
									>
										<i class="fa fa-trash"></i>
									</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-12 mt-5">
			<button class="btn btn-primary btn-block" type="submit">
				Guardar cambios
			</button>
		</div>
	</form>
</div>

@push('js')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		Livewire.on('update', data => {
			Swal.fire(data.status == 'success' ? 'Correcto' : 'Error', data.message, data.status);
		})
	</script>
@endpush
