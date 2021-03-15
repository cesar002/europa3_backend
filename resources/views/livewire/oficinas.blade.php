<div>

	<x-call-back-message />

    <div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Oficinas</strong>
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
								@foreach ($oficinas as $oficina)
									<tr>
										<td>
											<img src="{{ Storage::url($oficina->getImagesPath().'/'.$oficina->imagenes[0]->image) }}" alt="{{ $oficina->nombre }}"
												class="img-fluid" style="max-height: 100px; max-width: 200px;"
											>
										</td>
										<td>{{ $oficina->nombre }}</td>
										<td>{{ $oficina->edificio->nombre }}</td>
										<td>
											@money($oficina->precio)
										</td>
										<td>{{ $oficina->en_uso ? 'Si' : 'No' }}</td>
										<td class="btn-group">
											<a class="btn btn-primary btn-sm"
												href="{{ route('dashboard.oficinas.show', ['id' => $oficina->id]) }}"
											>
												<i class="fa fa-pencil-alt"></i>
											</a>
											<button class="btn btn-danger btn-sm"
												wire:click="$emit('delete-confirmation', {{ $oficina->id }})"
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

	<div wire:ignore.self class="modal fade" id="newOficina" tabindex="-1" role="dialog" aria-labelledby="newOficinaLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newOficinaLabel">
						<strong>Nueva oficina</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='submit'>
					@csrf
					<div class="modal-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="edificio_id">Edificio</label>
								<select wire:model='edificio_id' id="edificio_id"
									class="form-control {{$errors->has('edificio_id') ? 'is-invalid' : ''}}"
									wire:change='fetchMobiliario'
								>
									<option value="">Seleccione un edificio</option>
									@foreach ($edificios as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
									@endforeach
								</select>
								@error('edificio_id')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="size_id">Tamaño de oficina</label>
								<select name="size_id" id="size_id"
									class="form-control {{$errors->has('size_id') ? 'is-invalid' : ''}}"
									wire:model='size_id'
								>
									<option value="">Selecciona un tamaño</option>
									@foreach ($sizes as $item)
										<option value="{{$item->id}}">{{ $item->size_name }}</option>
									@endforeach
								</select>
								@error('size_id')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								wire:model='nombre'
								id="nombre"
							>
							@error('nombre')
								<x-invalid-feedback message='{{$message}}' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea wire:model='descripcion'id="descripcion" class="form-control" rows="5"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-6">
								<label for="dimensiones">Dimensiones de la oficina</label>
								<input type="text" class="form-control {{ $errors->has('dimensiones') ? 'is-invalid' : '' }}"
									wire:model='dimensiones'
									id="dimensiones"
								>
								@error('dimensiones')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="capacidad_recomendada">Capacidad recomendada</label>
								<input type="text"
									id="capacidad_recomendada"
									wire:model='capacidad_recomendada'
									class="form-control {{$errors->has('capacidad_recomendada') ? 'is-invalid' : ''}}"
								>
								@error('capacidad_recomendada')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="capacidad_maxima">Capacidad máxima</label>
								<input type="text"
									id="capacidad_maxima"
									wire:model='capacidad_maxima'
									class="form-control {{ $errors->has('capacidad_maxima') ? 'is-invalid' : '' }}"
								>
								@error('capacidad_maxima')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="precio">Precio</label>
								<input type="text"
									id="precio"
									wire:model='precio'
									class="form-control {{$errors->has('precio') ? 'is-invalid' : ''}}"
								>
								@error('precio')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="images">Imagenes</label>
							<input type="file" class="form-control-file {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images" accept="image/*"
								wire:model='images' multiple
							>
							@error('images')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-group">
							<label for="">Servicios</label>
						</div>
						<div class="form-row">
							<div class="col-12 col-sm-6">
								<select
									class="form-control {{ $errors->has('serviciosSelected') ? 'is-invalid' : '' }}"
									wire:model='servicio_selected'
								>
									<option value="">Elija un servicio</option>
									@foreach ($servicios as $item)
										<option value="{{$item->id}}">{{ $item->servicio }}</option>
									@endforeach
								</select>
								@error('serviciosSelected')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-4">
								<button class="btn btn-primary btn-sm" type="button"
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
										@foreach ($serviciosSelected as $i => $item)
											<tr>
												<td>{{$item['nombre']}}</td>
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
									class="form-control {{ $errors->has('mobiliarioSelected') ? 'is-invalid' : '' }}"
									wire:model='mobiliario_selected'
								>
									<option value="">Elija un mobiliario</option>
									@foreach ($mobiliario as $item)
										<option value="{{$item->id}}">{{ $item->nombre }}</option>
									@endforeach
								</select>
								@error('mobiliarioSelected')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-4">
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
										@foreach ($mobiliarioSelected as $i => $item)
											<tr>
												<td>{{$item['nombre']}}</td>
												<td>
													<input type="text"
														class="form-control w-25"
														wire:model="mobiliarioSelected.{{$i}}.cantidad"
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
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
		Livewire.on('delete-confirmation', id => {
			Swal.fire({
				title: 'Confirmación',
				html: "<strong>¿Está seguro de eliminar esta oficina?</strong> <br>  <p>eliminar el registro de esta oficina podría afectar a algún usuario que la tenga contratada, le recomendamos verificar la disponibilidad antes de realizar la eliminación</p>",
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
	<script>
		Livewire.on('register-success', e => {
			$('#newOficina').modal('toggle');
		});
	</script>
@endpush
