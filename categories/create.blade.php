@extends('layouts.app')

@section('content')

<div class="card-header">
	Add Product Line
</div>

<div class="card-body">
	<form method="POST" action="/categories" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
			<label for="name">Name: </label>
			<input class="form-control" type="text" name="name" id="name">
		</div>
		<div class="form-group">
			<label for="description">Description: </label>
			<input class="form-control" type="text" name="description" id="description">
		</div>
		
		<div class="form-group">
			<label for="image">Image:</label>
			<input class="form-control" type="file" name="image" id="image">
		</div>

		<button type="submit" class="btn btn-success">
			Save product line
		</button>
	</form>
</div>

@endsection