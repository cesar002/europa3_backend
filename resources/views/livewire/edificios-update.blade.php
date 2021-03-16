<div>
    <div class="row my-3">
		<div class="col-6">
			<a class="btn btn-primary" href="{{ route('dashboard.edificios.index') }}">
				Regresar
			</a>
		</div>
	</div>

	<x-call-back-message />

	<div class="row">
		<div class="col-12">
			<div class="card">
				<form wire:submit.prevent='submit'>
					<div class="card-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control {{ $errors->has('edificio.nombre') ? 'is-invalid' : '' }}"
									id="nombre"
									wire:model='edificio.nombre'
								>
								@error('edificio.nombre')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="direccion">Dirección</label>
								<input type="text" class="form-control {{ $errors->has('edificio.direccion') ? 'is-invalid' : '' }}"
									id="direccion"
									wire:model='edificio.direccion'
								>
								@error('edificio.direccion')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="estado">Estado</label>
								<select id="estado" class="form-control {{ $errors->has('edificio.municipio.estado.id') ? 'is-invalid' : '' }}"
									wire:model='edificio.municipio.estado.id'
									wire:change='getMunicipios'
								>
									<option value="">Seleccione un estado</option>
									@foreach ($estados as $estado)
										<option value="{{ $estado['id'] }}">{{ $estado['nombre'] }}</option>
									@endforeach
								</select>
								@error('edificio.municipio.estado.id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="municipio">Municipio</label>
								<select id="municipio" class="form-control {{ $errors->has('edificio.municipio_id') ? 'is-invalid' : '' }}"
									wire:model='edificio.municipio_id'
								>
									<option value="">Seleccione un municipio</option>
									@foreach ($municipios as $municipio)
										<option value="{{ $municipio['id'] }}">{{ $municipio['nombre'] }}</option>
									@endforeach
								</select>
								@error('edificio.municipio_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-4">
								<label for="telefono_1">Teléfono</label>
								<input type="text" id="telefono_1"
									class="form-control {{ $errors->has('edificio.telefono_1') ? 'is-invalid' : '' }}"
									wire:model='edificio.telefono_1'
								>
								@error('edificio.telefono_1')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-4">
								<label for="telefono_2">Teléfono 2</label>
								<input type="text" id="telefono_2"
									class="form-control"
									wire:model='edificio.telefono_2'
								>
							</div>
							<div class="col-12 col-sm-4">
								<label for="telefono_recepcion">Teléfono de recepción</label>
								<input type="text" id="telefono_recepcion"
									class="form-control {{ $errors->has('edificio.telefono_recepcion') ? 'is-invalid' : '' }}"
									wire:model='edificio.telefono_recepcion'
								>
								@error('edificio.telefono_recepcion')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-3">
								<label for="hora_apertura">Hora de apertura</label>
								<input type="time"
									id="hora_apertura"
									class="form-control {{ $errors->has('edificio.hora_apertura') ? 'is-invalid' : '' }}"
									wire:model='edificio.hora_apertura'
								>
								@error('edificio.hora_apertura')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-3">
								<label for="hora_cierre">Hora de cierre</label>
								<input type="time"
									id="hora_cierre"
									class="form-control {{ $errors->has('edificio.hora_cierre') ? 'is-invalid' : ''}}"
									wire:model='edificio.hora_cierre'
								>
								@error('edificio.hora_cierre')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12">
								<label for="">Idiomas de atención</label>
							</div>
							<div class="col-4">
								<select class="form-control {{ $errors->has('edificio.idiomas') ? 'is-invalid' : '' }}"
									wire:model='idiomaSelected'
								>
									<option value="">Seleccione un idioma</option>
									@foreach ($idiomas as $idioma)
										<option value="{{ $idioma->id }}">{{ $idioma->idioma }}</option>
									@endforeach
								</select>
								@error('edificios.idiomas')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-3">
								<button class="btn btn-primary btn-sm" type="button" wire:click='addIdioma'>
									Agregar
								</button>
							</div>
						</div>
						<div class="form-row">
							<div class="col-6">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Idioma</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($edificio['idiomas'] as $i => $idioma)
												<tr>
													<td>{{ $idioma['idioma'] }}</td>
													<td>
														<button class="btn btn-danger btn-sm"
															type="button" wire:click='removeIdioma({{ $i }})'
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
					<div class="card-footer">
						<button class="btn btn-primary btn-block" type="submit">
							Guardar cambios
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
