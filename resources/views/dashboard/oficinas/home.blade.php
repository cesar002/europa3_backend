@extends('layouts.app-admin')

@section('title')
	<title>Oficinas</title>
@endsection

@section('body')
	<div class="row my-3">
		<div class="col-6">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newOficina">
				Registrar oficina
			</button>
		</div>
	</div>

	@livewire('oficinas', [
		'oficinas' => $oficinas,
		'edificios' => $edificios,
		'sizes' => $sizes,
		'servicios' => $servicios,
	])

	@livewireScripts
@endsection
