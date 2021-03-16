@extends('layouts.app-admin')

@section('title')
	<title>Sala de juntas - {{ $sala->nombre }} - imagenes</title>
@endsection

@section('body')
	<div class="row my-3">
		<div class="col-6">
			<a href="{{ route('dashboard.sala-juntas.index') }}" class="btn btn-primary">
				Regresar
			</a>
		</div>
	</div>

	<div class="row my-5 px-0 px-sm-5">
		<div class="col-12">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('dashboard.sala-juntas.show', ['id' => $sala->id]) }}">
						Detalles / Edición
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="{{ route('dashboard.sala-juntas.updateImages', ['id' => $sala->id]) }}">Imagenes</a>
				</li>
			</ul>
			<div class="card">
				<div class="card-body">
					@livewire('sala-juntas-image-update', [
						'sala' => $sala
					])
				</div>
			</div>
		</div>
	</div>

@livewireScripts
@endsection
