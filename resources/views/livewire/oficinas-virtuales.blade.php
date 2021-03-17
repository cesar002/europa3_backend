<div>

	<x-call-back-message />

    <div class="row my-5">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Oficinas Virtuales</strong>
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Edificio</th>
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Precio</th>
									<th>En uso</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($oficinasVirtuales as $oficina)
									<tr>
										<td>{{ $oficina->edificio->nombre }}</td>
										<td>{{ $oficina->nombre }}</td>
										<td>{{ $oficina->descripcion }}</td>
										<td>
											@money($oficina->precio)
										</td>
										<td>{{ $oficina->en_uso ? 'Si' : 'No' }}</td>
										<td class="btn-group">
											<button  class="btn btn-primary btn-sm"
												data-toggle="modal" data-target="#updateOficina"
												wire:click="setOficina({{ $oficina }})"
											>
												<i class="fa fa-pencil-alt"></i>
											</button>
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


	<div wire:ignore.self class="modal fade" id="updateOficina" tabindex="-1" role="dialog" aria-labelledby="updateOficinaTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateOficinaTitle">
						<strong>Actualizar oficina</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='update'>
					<div class="modal-body">
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text"
								class="form-control {{ $errors->has('oficinaSelected.nombre') ? 'is-invalid' : '' }}"
								id="nombre"
								wire:model='oficinaSelected.nombre'
							>
							@error('oficinaSelected.nombre')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="edificios">Edificios</label>
							<select wire:model='oficinaSelected.edificio_id' id="edificios"
								class="form-control {{ $errors->has('oficinaSelected.edificio_id') ? 'is-invalid' : '' }}"
							>
								<option value="">Seleccione un edificio</option>
								@foreach ($edificios as $edificio)
									<option value="{{ $edificio->id }}">{{ $edificio->nombre }}</option>
								@endforeach
							</select>
							@error('oficinaSelected.edificio_id')
								<x-invalid-feedback :message='$message' />
							@enderror
						</div>
						<div class="form-group">
							<label for="descripcion">Descripción</label>
							<textarea wire:model='oficinaSelected.descripcion' id="descripcion" class="form-control" rows="4"></textarea>
						</div>
						<div class="form-row my-2">
							<div class="col-4">
								<label for="precio">Precio</label>
								<input type="text"
									id="precio"
									class="form-control {{ $errors->has('oficinaSelected.precio') ? 'is-invalid' : '' }}"
									wire:model='oficinaSelected.precio'
								>
								@error('oficinaSelected.precio')
									<x-invalid-feedback :message='$message' />
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
		Livewire.on('delete-confirmation', id => {
			Swal.fire({
				title: 'Confirmación',
				html: "<strong>¿Está seguro de eliminar esta oficina virtual?</strong> <br>  <p>eliminar el registro de esta oficina podría afectar a algún usuario que la tenga contratada, le recomendamos verificar la disponibilidad antes de realizar la eliminación</p>",
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
		Livewire.on('update-success', e => {
			$('#updateOficina').modal('toggle');
		});
	</script>
@endpush
