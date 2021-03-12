@extends('layouts.app-admin')

@section('title')
	<title>Edificios</title>
@endsection

@section('body')

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
										<td>{{ $edificio->nombre }}</td>
										<td>{{ $edificio->municipio->nombre }}</td>
										<td>{{ $edificio->municipio->estado->nombre }}</td>
										<td>{{ $edificio->direccion }}</td>
										<td>{{ $edificio->telefono_1 }}</td>
										<td>{{ $edificio->hora_apertura }} - {{ $edificio->hora_cierre }}</td>
										<td>
											<a class="btn btn-primary btn-sm"
												href="{{ route('dashboard.edificios.show', ['id' => $edificio->id]) }}"
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

	<div class="modal fade" id="newEdificio" tabindex="-1" role="dialog" aria-labelledby="newEdificioLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newEdificioLabel"><strong>Nuevo edificio</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="" method="post">
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
