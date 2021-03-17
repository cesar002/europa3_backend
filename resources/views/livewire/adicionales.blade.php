<div>
    <x-call-back-message />

	<div class="row my-5">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Adicionales</strong>
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Cantidad máxima de compra</th>
									<th>Precio</th>
									<th>Disponible</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($adicionales as $adicional)
									<tr>
										<td>{{ $adicional->nombre }}</td>
										<td>{{ $adicional->descripcion }}</td>
										<td>{{ $adicional->cantidad_maxima }}</td>
										<td>{{ $adicional->precio }}</td>
										<td>{{ $adicional->disponible ? 'Si' : 'No' }}</td>
										<td class="btn-group">
											<button class="btn btn-primary btn-sm"
												data-toggle="modal" data-target="#updateAdicional"
												wire:click='selectAdicional({{ $adicional }})'
											>
												<i class="fa fa-pencil-alt"></i>
											</button>
											<button class="btn btn-danger btn-sm"
												wire:click="$emit('delete-adicional', {{ $adicional->id }})"
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

	<div wire:ignore.self class="modal fade" id="updateAdicional" tabindex="-1" role="dialog" aria-labelledby="updateAdicionalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateAdicionalLabel">
						<strong>Actualizar adicional</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='update'>
					<div class="modal-body">
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="edificio">Edificio</label>
								<select wire:model="adicionalSelected.edificio_id" id="edificio"
									class="form-control {{ $errors->has('adicionalSelected.edificio_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Selecciona un edificio</option>
									@foreach ($edificios as $item)
										<option value="{{ $item->id }}">{{ $item->nombre }}</option>
									@endforeach
								</select>
								@error('adicionalSelected.edificio_id')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="unidad">Tipo de unidad</label>
								<select wire:model="adicionalSelected.unidad_id" id="unidad"
									class="form-control {{ $errors->has('adicionalSelected.unidad_id') ? 'is-invalid' : '' }}"
								>
									<option value="">Selecciona una unidad</option>
									@foreach ($unidades as $item)
										<option value="{{$item->id}}">{{ $item->unidad }}</option>
									@endforeach
								</select>
								@error('adicionalSelected.unidad_id')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" wire:model="adicionalSelected.nombre" id="adicionalSelected.nombre"
								class="form-control {{ $errors->has('adicionalSelected.nombre') ? 'is-invalid' : '' }}"
							>
							@error('adicionalSelected.nombre')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea wire:model="adicionalSelected.descripcion" id="descripcion" class="form-control" rows="5"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-12 col-sm-6">
								<label for="cantidad_maxima">Cantidad máxima para comprar</label>
								<input type="number" id="cantidad_maxima"
									class="form-control {{ $errors->has('adicionalSelected.cantidad_maxima') ? 'is-invalid' : '' }}"
									wire:model="adicionalSelected.cantidad_maxima"
								>
								@error('adicionalSelected.cantidad_maxima')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
							<div class="col-12 col-sm-6">
								<label for="precio">Precio</label>
								<input type="number"
									id='precio'
									wire:model="adicionalSelected.precio"
									class="form-control {{ $errors->has('adicionalSelected.precio') ? 'is-invalid' : '' }}"
								>
								@error('adicionalSelected.precio')
									<x-invalid-feedback message='{{$message}}' />
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		Livewire.on('delete-adicional', id => {
			Swal.fire({
				title: 'Confirmación',
				text: "¿está seguro que desea eliminar el adicional?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						@this.call('delete', id);
					}
				})
		});
	</script>
	<script>
		Livewire.on('update-success', e => {
			$('#updateAdicional').modal('toggle')
		})
	</script>
@endpush
