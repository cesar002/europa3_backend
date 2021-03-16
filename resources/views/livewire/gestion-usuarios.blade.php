<div>

	<x-call-back-message />

    <div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Nombre de usuario</th>
					<th>Nombre</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($usuarios as $user)
					<tr>
						<td>
							@if ($user->getAvatar() != null)
							<img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}"
								class="img-thumbnail img-fluid"
								style="max-height: 100px; max-width: 100px;"
							>
							@endif
						</td>
						<td>{{ $user->username }}</td>
						<td>{{ $user->getFullName() }}</td>
						<td class="btn-group">
							<a href="{{ route('dashboard.gestion-usuario.show', ['id' => $user->id]) }}" class="btn btn-primary btn-sm">
								<i class="fa fa-pencil-alt"></i>
							</a>
							@if (Auth::guard('admin')->user()->id != $user->id)
							<button class="btn btn-danger btn-sm"
								type="button"
								wire:click="$emit('confirm-delte', {{ $user->id }})"
							>
								<i class="fa fa-trash"></i>
							</button>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@push('js')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script>
		Livewire.on('confirm-delte', id => {
			Swal.fire({
				title: 'Confirmación',
				text: "¿Está seguro de eliminar este usuario?",
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
