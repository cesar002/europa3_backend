<div>

	<x-call-back-message />

	<form wire:submit.prevent='submit' class="my-3">
		<div class="form-group">
			<label for="images">Subir imagenes</label>
			<input type="file" class="form-control-file {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images"
				accept="image/*"
				wire:model='images'
				multiple
			>
			@error('images')
				<x-invalid-feedback message='{{$message}}' />
			@enderror
		</div>
		<div class="form-group">
			<button class="btn btn-primary" type="submit">
				Subir archivos
			</button>
		</div>
	</form>
    <div class="row my-3 my-sm-0">
		@foreach ($oficina->imagenes as $imagen)
			<div class="col-12 col-sm-4 px-3 my-4">
				<button class="btn btn-danger btn-sm position-absolute"
					wire:click='deleteImage({{ $imagen }})'
				>
					<i class="fa fa-trash"></i>
				</button>
				<div class="d-flex justify-content-center align-items-center">
					<img src="{{ Storage::url($oficina->getImagesPath().'/'.$imagen->image) }}" alt="{{$oficina->nombre}}"
						class="img-fluid"
						style="max-height: 300px; max-width: 250px;"
					>
				</div>
			</div>
		@endforeach
	</div>
</div>
