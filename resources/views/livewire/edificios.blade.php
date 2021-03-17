<div>

	<x-call-back-message />

	<div class="row mt-3">
		<div class="col-6">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target = '#newEdificio'>
				Registrar nuevo edificio
			</button>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Edificios</strong>
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-dark table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Estado</th>
									<th>Municipio</th>
									<th>Dirección</th>
									<th>Teléfono</th>
									<th>Horario</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($edificios as $edificio)
									<tr>
										<td>{{ $edificio['nombre'] }}</td>
										<td>{{ $edificio['municipio']['nombre'] }}</td>
										<td>{{ $edificio['municipio']['estado']['nombre'] }}</td>
										<td>{{ $edificio['direccion'] }}</td>
										<td>{{ $edificio['telefono_1'] }}</td>
										<td>{{ $edificio['hora_apertura'] }} - {{ $edificio['hora_cierre'] }}</td>
										<td>
											<a class="btn btn-primary btn-sm"
												href="{{ route('dashboard.edificios.show', ['id' => $edificio['id'] ]) }}"
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

	<div wire:ignore.self class="modal fade" id="newEdificio" tabindex="-1" role="dialog" aria-labelledby="newEdificioLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newEdificioLabel"><strong>Nuevo edificio</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='submit'>
					<div class="modal-body">
						<div class="form-group">
							<label for="nombre">Nombre del edificio*</label>
							<input type="text" id="nombre"
								class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
								wire:model='nombre'
							>
							@error('nombre')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-row my-3">
							<div class="col-12 col-sm-6">
								<label for="estado">Estado</label>
								<select id="estado" class="form-control {{ $errors->has('estado_id') ? 'is-invalid' : '' }}"
									wire:model='estado_id'
									wire:change='getMunicipios'
								>
									<option value="">Seleccione un estado</option>
									@foreach ($estados as $estado)
										<option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
									@endforeach
								</select>
								@error('estado_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="municipio">Municipio*</label>
								<select id="municipio" class="form-control {{ $errors->has('municipio_id') ? 'is-invalid' : '' }}"
									wire:model='municipio_id'
								>
									<option value="">Seleccione un municipio*</option>
									@foreach ($municipios as $municipio)
										<option value="{{ $municipio->id }}">{{$municipio->nombre}}</option>
									@endforeach
								</select>
								@error('municipio_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="direccion">Dirección*</label>
							<input type="text" id="direccion"
								class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}"
								wire:model='direccion'
							>
							@error('direccion')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-4">
								<label for="telefono">Teléfono*</label>
								<input type="text" id="telefono"
									class="form-control {{ $errors->has('telefono_1') ? 'is-invalid' : '' }}"
									wire:model='telefono_1'
								>
								@error('telefono_1')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-4">
								<label for="telefono_2">Teléfono 2</label>
								<input type="text" id="telefono_2"
									class="form-control"
									placeholder="opcional"
									wire:model='telefono_2'
								>
							</div>
							<div class="col-12 col-sm-4">
								<label for="telefono_recepcion">Teléfono de recepción</label>
								<input type="text" id="telefono_recepcion"
									class="form-control {{ $errors->has('telefono_recepcion') ? 'is-invalid' : '' }}"
									wire:model='telefono_recepcion'
								>
								@error('telefono_recepcion')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-4">
								<label for="hora_apertura">Hora de apertura*</label>
								<input type='time' id='hora_apertura'
									class="form-control {{ $errors->has('hora_apertura') ? 'is-invalid' : '' }}"
									wire:model='hora_apertura'
								>
								@error('hora_apertura')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-4">
								<label for="hora_cierre">Hora de cierre*</label>
								<input type='time'
									id="hora_cierre"
									class="form-control {{ $errors->has('hora_cierre') ? 'is-invalid' : '' }}"
									wire:model='hora_cierre'
								>
								@error('hora_cierre')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-row my-3">
							<div class="col-12">
								<label for="">Idiomas de atención</label>
							</div>
							<div class="col-6 col-sm-4">
								<select id="idiomas_atencion" class="form-control {{ $errors->has('idiomasSelected') ? 'is-invalid' : '' }}"
									wire:model='idiomaSelected'
								>
									<option value="">Seleccione el idioma</option>
									@foreach ($idiomas as $idioma)
										<option value="{{ $idioma->id }}">{{ $idioma->idioma }}</option>
									@endforeach
								</select>
								@error('idiomasSelected')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-6 col-sm-3">
								<button class="btn btn-primary btn-sm" type="button"
									wire:click='addIdioma'
								>
									Agregar
								</button>
							</div>
						</div>
						<div class="form-row">
							<div class="col-16">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Idioma</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($idiomasSelected as $i => $idioma)
												<tr>
													<td>{{ $idioma['idioma'] }}</td>
													<td>
														<button class="btn btn-danger btn-sm"
															type="button"
															wire:click='removeIdioma({{ $i }})'
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
	<script>
		Livewire.on('SUBMIT_SUCCESS', e => {
			$('#newEdificio').modal('toggle')
		})
	</script>
@endpush
