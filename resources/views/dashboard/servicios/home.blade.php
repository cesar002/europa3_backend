@extends('layouts.app-admin')

@section('title')
	<title>Servicios</title>
@endsection

@section('body')

@livewire('servicios', [
	'servicios' => $servicios->toArray(),
]);

@livewireScripts
@endsection
