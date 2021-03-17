@extends('layouts.app-admin')

@section('title')
	<title>Edificios</title>
@endsection

@section('body')

@livewire('edificios', [
	'edificios' => $edificios->toArray(),
])

@livewireScripts
@endsection
