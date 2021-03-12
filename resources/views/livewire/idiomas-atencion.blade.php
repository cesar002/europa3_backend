<div>

	<x-call-back-message />

	<div class="row my-3">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<form wire:submit.prevent='submit'>
						<div class="form-row">
							<div class="col-12 my-3">
								<h3><strong>Idiomas de atención</strong></h3>
							</div>
							<div class="col-12 col-sm-6">
								<input type="text" class="form-control {{ $errors->has('idioma') ? 'is-invalid' : '' }}" placeholder="Nombre del idioma"
									wire:model='idioma'
								>
								@error('idioma')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-3 my-3 my-sm-0">
								<button class="btn btn-primary btn-sm" type="submit">
									<i class="fa fa-plus"></i>
									Agregar idioma
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Idioma</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($idiomas as $idioma)
									<tr>
										<td>{{ $idioma->idioma }}</td>
										<td class="btn-group">
											<button class="btn btn-primary btn-sm"
												data-toggle="modal" data-target='#updateIdioma'
												wire:click="$set('idiomaSelected', {{$idioma}})"
											>
												<i class="fa fa-pencil-alt"></i>
											</button>
											<button class="btn btn-danger btn-sm"
												wire:click="$emit('delete-idioma', {{ $idioma->id }})"
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

	<div wire:ignore.self class="modal fade" id="updateIdioma" tabindex="-1" role="dialog" aria-labelledby="updateIdiomaLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateIdiomaLabel">Actualizar idioma</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='updateIdioma'>
					<div class="modal-body">
						<div class="form-group">
							<label for="idioma">Idioma</label>
							<input type="text"
								class="form-control {{ $errors->has('idiomaSelected.idioma') ? 'is-invalid' : '' }}"
								wire:model='idiomaSelected.idioma'
							>
							@error('idiomaSelected.idioma')
								<x-invalid-feedback message='{{ $message }}' />
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('js')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		Livewire.on('delete-idioma', id => {
			Swal.fire({
				title: 'Confirmación',
				text: "¿está seguro que desea eliminar el idioma?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'No'
				})
				.then((result) => {
					if (result.isConfirmed) {
						@this.call('delete', id);
					}
				})
		});
	</script>
	<script>
		Livewire.on('UPDATE_SUCCESS', e => {
			$('#updateIdioma').modal('toggle');
		});
	</script>
@endpush
