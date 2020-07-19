@extends('layouts.app')

@section('content')

<div class="card-header">
	Edit Product Line
</div>

<div class="card-body">
	<form method="POST" action="/categories/{{ $category->id }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="form-group">
			<label for="name">Name: </label>
			<input class="form-control" type="text" name="name" id="name" value="{{ $category->name }}">
		</div>
		<div class="form-group">
			<label for="description">Description: </label>
			<input class="form-control" type="text" name="description" id="description" value="{{ $category->description }}">
		</div>
		
		<div class="form-group">
			<label for="image">Image:</label>
			<input class="form-control" type="file" name="image" id="image">
		</div>

		<button type="submit" class="btn btn-success">
			Update Product Line
		</button>
	</form>
</div>


@endsection