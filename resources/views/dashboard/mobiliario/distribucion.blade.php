@extends('layouts.app-admin')

@section('title')
	<title>Mobiliario - {{ $mobiliario->nombre }}</title>
@endsection

@section('body')

	<div class="row my-3">
		<div class="col-6">
			<a href="{{ route('dashboard.mobiliario.index') }}"
				class="btn btn-primary"
			>
				Regresar
			</a>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12 px-5">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('dashboard.mobiliario.show', ['id' => $mobiliario->id]) }}">
						Detalles/Edición
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="{{ route('dashboard.mobiliario.distribucion', ['id' => $mobiliario->id]) }}">
						Distribucción
					</a>
				</li>
			</ul>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<strong>Distribución</strong>
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Tipo</th>
									<th>Oficina / Sala de juntas</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($mobiliario->mobiliarioAsignadoOficina as $asignado)
									<tr>
										<td>{{ $asignado->oficina->tipoOficina->tipo }}</td>
										<td>{{ $asignado->oficina->nombre }}</td>
										<td>{{ $asignado->cantidad }}</td>
									</tr>
								@endforeach
								@foreach ($mobiliario->mobiliarioAsignadoSalaJuntas as $asignado)
									<tr>
										<td>{{ $asignado->salaJuntas->tipoOficina->tipo }}</td>
										<td>{{ $asignado->salaJuntas->nombre }}</td>
										<td>{{ $asignado->cantidad }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					<div class="my-2">
						<strong>Disponibles: {{ $mobiliario->cantidad }}</strong>
					</div>
					<div class="my-2">
						<strong>En uso: {{ $enUso }}</strong>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
