<div>

	<x-call-back-message />

	<div class="row my-3">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<form wire:submit.prevent='submit'>
						<div class="form-row">
							<div class="col-12 my-3">
								<h3 class="card-title">Servicios</h3>
							</div>
							<div class="col-12 col-sm-5">
								<input type="text" placeholder="Servicio"
									class="form-control {{ $errors->has('servicio') ? 'is-invalid' : '' }}"
									wire:model='newServicio'
								>
								@error('servicio')
									<x-invalid-feedback message='{{ $message }}' />
								@enderror
							</div>
							<div class="col-12 col-sm-3 my-3 my-sm-0">
								<button class="btn btn-primary btn-sm" type="submit">
									<i class="fa fa-plus"></i>
									Agregar servicio
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
									<th>Servicio</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($servicios as $i => $item)
									<tr>
										<td>{{ $item['servicio'] }}</td>
										<td class="btn-group">
											<button class="btn btn-primary btn-sm"
												data-toggle="modal" data-target="#servicioUpdate"
												wire:click='selectServicio({{ $i }})'
											>
												<i class="fa fa-pencil-alt"></i>
											</button>
											<button class="btn btn-danger btn-sm"
												wire:click="$emit('DELETE_CONFIRMATION', {{ $item['id'] }})"
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

	<div wire:ignore.self class="modal fade" id="servicioUpdate" tabindex="-1" role="dialog" aria-labelledby="servicioUpdateLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="servicioUpdateLabel">Actualizar servicio</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form wire:submit.prevent='update'>
					<div class="modal-body">
						<div class="form-group">
							<label for="update-servicio">Servicio</label>
							<input type="text"
								id="update-servicio"
								wire:model='servicioSelected.servicio'
								class="form-control {{ $errors->has('servicioSelected.servicio') ? 'is-invalid' : '' }}"
							>
							@error('servicioSelected.servicio')
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
		Livewire.on('DELETE_CONFIRMATION', id => {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
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
		Livewire.on('UPDATE_SUCCESS', e => {
			$('#servicioUpdate').modal('toggle')
		});
	</script>
@endpush
