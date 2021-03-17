<div>
    <div class="row-my-3">
		<div class="col-6">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newSala">
				Registrar nueva sala de juntas
			</button>
		</div>
	</div>

	<x-call-back-message />

	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Sala de juntas</strong>
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Imagen Prev</th>
									<th>Nombre</th>
									<th>Edificio</th>
									<th>Precio</th>
									<th>Disponible</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($salas as $sala)
									<tr>
										<td>
											<img src="{{ Storage::url($sala->getImagesPath().'/'.$sala->imagenes[0]->image) }}"
												alt="{{ $sala->nombre }}"
												class="img-fluid"
												style="max-height: 200px; max-width: 150px;"
											>
										</td>
										<td>{{ $sala->nombre }}</td>
										<td>{{ $sala->edificio->nombre }}</td>
										<td>
											@money($sala->precio)
										</td>
										<td>{{ $sala->en_uso ? 'Si' : 'No' }}</td>
										<td class="btn-group">
											<a class="btn btn-primary btn-sm"
												href="{{ route('dashboard.sala-juntas.show', ['id' => $sala->id]) }}"
											>
												<i class="fa fa-pencil-alt"></i>
											</a>
											<button class="btn btn-danger btn-sm"
												wire:click="$emit('delete-confirmation', {{ $sala->id }})"
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
			</div>
		</div>
	</div>

	<div wire:ignore.self class="modal fade" id="newSala" tabindex="-1" role="dialog" aria-labelledby="newSalaLabel" aria-hidden="true">
		<div class="modal-dialog " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newSalaLabel">
						<strong>Registrar sala de juntas</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='submit'>
					<div class="modal-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="edificio_id">Edificio</label>
								<select id="edificio_id"
									class="form-control {{ $errors->has('edificio_id') ? 'is-invalid' : '' }}"
									wire:model='edificio_id'
									wire:change='fetchMobiliario'
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
							<div class="col-12 col-sm-6">
								<label for="size_id">Tamaño</label>
								<select wire:model='size_id' id="size_id"
									class="form-control {{ $errors->has('size_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un tamaño</option>
									@foreach ($sizes as $item)
										<option value="{{ $item->id }}">{{ $item->size_name }}</option>
									@endforeach
								</select>
								@error('size_id')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre de la sala de juntas</label>
							<input type="text"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								wire:model='nombre'
								id="nombre"
							>
							@error('nombre')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea wire:model='descripcion' id="descripcion" class="form-control" rows="5"></textarea>
						</div>
						<div class="form-group">
							<label for="images">Imagenes de la sala de juntas</label>
							<input type="file" id="images" wire:model='images' multiple accept="images/*" class="form-control-file {{ $errors->has('images') ? 'is-invalid' : '' }}">
							@error('images')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="dimension">Dimensiones</label>
								<input type="text" id="dimension"
									class="form-control {{ $errors->has('dimension') ? 'is-invalid' : '' }}"
									wire:model='dimension'
								>
								@error('dimension')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="precio">Precio</label>
								<input type="text"
									id="precio"
									class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}"
									wire:model='precio'
								>
								@error('precio')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="capacidad_recomendada">Capacidad recomendada</label>
								<input type="text"
									id="capacidad_recomendada"
									class="form-control {{ $errors->has('capacidad_recomendada') ? 'is-invalid' : '' }}"
									wire:model='capacidad_recomendada'
								>
								@error('capacidad_recomendada')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="capacidad_maxima">Capacidad máxima</label>
								<input type="text"
									id="capacidad_maxima"
									class="form-control {{ $errors->has('capacidad_maxima') ? 'is-invalid' : '' }}"
									wire:model='capacidad_maxima'
								>
								@error('capacidad_maxima')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
						</div>
						<label for="">Servicios</label>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<select wire:model='servicio_selected'
									class="form-control {{ $errors->has('servicios_list') ? 'is-invalid' : '' }}"
								>
									<option value="">Seleccione un servicio</option>
									@foreach ($servicios as $item)
										<option value="{{ $item->id }}">{{ $item->servicio }}</option>
									@endforeach
								</select>
								@error('servicios_list')
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
										@foreach ($servicios_list as $i => $servicio)
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
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>

@push('js')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		Livewire.on('register-success', e => {
			$('#newSala').modal('toggle')
		})
	</script>
	<script>
		Livewire.on('delete-confirmation', id => {
			Swal.fire({
				title: 'Confirmación',
				html: "<strong>¿Está seguro de eliminar esta sala de juntas?</strong> <br>  <p>eliminar el registro de esta oficina podría afectar a algún usuario que la tenga contratada, le recomendamos verificar la disponibilidad antes de realizar la eliminación</p>",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed){
						@this.call('delete', id)
					}
			})
		})
	</script>
@endpush
