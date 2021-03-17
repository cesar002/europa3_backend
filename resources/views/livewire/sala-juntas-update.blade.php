<div>

	<x-call-back-message />

	<form wire:submit.prevent='submit'>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<label for="edificio_id">Edificio</label>
				<select id="edificio_id"
					class="form-control {{ $errors->has('sala.edificio_id') ? 'is-invalid' : '' }}"
					wire:model='sala.edificio_id'
					wire:change='fetchMobiliario'
				>
					<option value="">Seleccione un edificio</option>
					@foreach ($edificios as $item)
						<option value="{{ $item->id }}">{{ $item->nombre }}</option>
					@endforeach
				</select>
				@error('sala.edificio_id')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<label for="size_id">Tamaño</label>
				<select id="size_id" wire:model='sala.size_id'
					class="form-control {{ $errors->has('sala.size_id') ? 'is-invalid' : '' }}"
				>
					<option value="">Seleccione un tamaño</option>
					@foreach ($sizes as $item)
						<option value="{{ $item->id }}">{{ $item->size_name }}</option>
					@endforeach
				</select>
				@error('sala.size_id')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
		</div>
		<div class="form-group">
			<label for="nombre">Nombre de la sala de juntas</label>
			<input type="text"
				id="nombre"
				class="form-control {{ $errors->has('sala.nombre') ? 'is-invalid' : '' }}"
				wire:model='sala.nombre'
			>
			@error('sala.nombre')
				<x-invalid-feedback :message='$message' />
			@enderror
		</div>
		<div class="form-group">
			<label for="descripcion">Descripción</label>
			<textarea wire:model='sala.descripcion' id="descripcion" class="form-control" rows="5"></textarea>
		</div>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<label for="dimension">Dimensiones</label>
				<input type="text" id="dimension"
					class="form-control {{ $errors->has('sala.size_dimension') ? 'is-invalid' : '' }}"
					wire:model='sala.size_dimension'
				>
				@error('sala.size_dimension')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<label for="precio">Precio</label>
				<input type="text"
					id="precio"
					class="form-control {{ $errors->has('sala.precio') ? 'is-invalid' : '' }}"
					wire:model='sala.precio'
				>
				@error('sala.precio')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
		</div>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<label for="capacidad_recomendada">Capacidad recomendada</label>
				<input type="text"
					id="capacidad_recomendada"
					class="form-control {{ $errors->has('sala.capacidad_recomendada') ? 'is-invalid' : '' }}"
					wire:model='sala.capacidad_recomendada'
				>
				@error('sala.capacidad_recomendada')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<label for="capacidad_maxima">Capacidad máxima</label>
				<input type="text"
					id="capacidad_maxima"
					class="form-control {{ $errors->has('sala.capacidad_maxima') ? 'is-invalid' : '' }}"
					wire:model='sala.capacidad_maxima'
				>
				@error('sala.capacidad_maxima')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
		</div>
		<label for="">Servicios</label>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<select wire:model='servicio_selected'
					class="form-control {{ $errors->has('sala.servicios') ? 'is-invalid' : '' }}"
				>
					<option value="">Seleccione un servicio</option>
					@foreach ($servicios as $item)
						<option value="{{ $item->id }}">{{ $item->servicio }}</option>
					@endforeach
				</select>
				@error('sala.servicios')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<button class="btn btn-primary btn-sm my-3 my-sm-0"
					wire:click='addNewServicio'
					type="button"
				>
					Agregar
				</button>
			</div>
			<div class="col-12 py-3">
				<table class="table">
					<thead>
						<tr>
							<th>Servicio</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($sala['servicios'] as $i => $servicio)
							<tr>
								<td>{{ $servicio['servicio'] }}</td>
								<td>
									<button class="btn btn-sm btn-danger"
										wire:click='removeNewServicio({{ $i }})'
										type="button"
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
		<label for="">Mobiliario</label>
		<div class="form-row my-2">
			<div class="col-12 col-sm-6">
				<select wire:model='mobiliario_selected'
					class="form-control {{ $errors->has('mobiliario_list') ? 'is-invalid' : '' }}"
				>
					<option value="">Seleccione un mobiliario</option>
					@foreach ($mobiliario as $item)
						<option value="{{ $item->id }}">{{ $item->nombre }}</option>
					@endforeach
				</select>
				@error('mobiliario_list')
					<x-invalid-feedback :message='$message' />
				@enderror
			</div>
			<div class="col-12 col-sm-6">
				<button class="btn btn-primary btn-sm my-3 my-sm-0"
					type="button"
					wire:click='addNewMobiliario'
				>
					Agregar
				</button>
			</div>
			<div class="col-12 py-3">
				<table class="table">
					<thead>
						<tr>
							<th>Mobiliario</th>
							<th>Cantidad</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($mobiliario_list as $i => $mobiliario)
							<tr>
								<td>{{ $mobiliario['nombre'] }}</td>
								<td>
									<input type="text"
										class="form-control {{ $errors->has('mobiliario_list.'.$i.'.cantidad') ? 'is-invalid' : '' }}"
										wire:model="mobiliario_list.{{$i}}.cantidad"
									>
									@error('mobiliario_list.'.$i.'.cantidad')
										<x-invalid-feedback :message='$message' />
									@enderror
								</td>
								<td>
									<button
										type="button"
										class="btn btn-danger btn-sm"
										wire:click='removeNewMobiliario({{$i}})'
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
		<div class="form-group mt-4">
			<button class="btn btn-primary btn-block" type="submit">
				Guardar cambios
			</button>
		</div>
	</form>
</div>
