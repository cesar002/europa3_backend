@extends('layouts.app-admin')

@section('title')
	<title>Sala de juntas</title>
@endsection

@section('body')

@livewire('sala-juntas', [
	'salas' => $salas,
	'edificios' => $edificios,
	'sizes' => $sizes,
	'servicios' => $servicios,
])

@livewireScripts
@endsection
