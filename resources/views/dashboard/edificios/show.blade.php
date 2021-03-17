@extends('layouts.app-admin')

@section('title')
	<title>Edificio {{ $edificio->nombre }}</title>
@endsection

@section('body')

@livewire('edificios-update', [
	'edificio' => $edificio->toArray(),
])

@livewireScripts
@endsection
