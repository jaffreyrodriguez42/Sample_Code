@extends('layouts.app')

@section('content')

<div class="card">
	<div class="container-fluid">
		<div class="wrapper row">
			<div class="preview col-md-6 col-lg-6">
				
				<div class="preview-pic tab-content">
				  <div class="categoryPic tab-pane active" id="pic-1"><img src="{{ asset($category->img_path) }}" {{-- class="img-fluid --}} /></div>

				</div>
		
				
			</div>
			<div class="details col-md-6 col-lg-6">
				<h2 class="product-title">{{ $category->name }}</h2>
				<div class="rating mb-5">
					<div class="stars">
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star"></span>
						<span class="fa fa-star"></span>
					</div>
					<p class="product-description"><h5>{{ $category->description }}</h5></p>

					<span class="review-no mr-5"><span>Total: </span>{{ $asset_count['total'] }}</span>
					<span class="review-no m-5"><span>Available: </span>{{ $asset_count['available'] }}</span>
					<span class="review-no m-5"><span>Unavailable: </span>{{ $asset_count['unavailable'] }}</span>



				</div>
				
				@if($category->isActive == 1)
					<h4 class="price">Status: <span>Active</span></h4>
				@else
					<h4 class="price">Status: <span>Inactive</span></h4>
				@endif

				<a href="../assets/create" class="btn btn-primary mt-5 mb-5"><h5>Add new asset</h5></a>

			</div>
		</div>
	</div>
</div>

 	{{-- list of a particular category --}}

    <div class="row col-md-12 custyle">
    <table class="table table-striped custab">
    <thead>

        <tr>
           
            <th>Serial Number</th>
            <th>Status</th>
            <th class="text-center align-middle" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($category->assets as $asset)
            <tr>
            	
                <td class="align-middle">{{$asset->serial_number}}</td>
                <td class="align-middle">
					@if($asset->isAvailable == 1)
					{{"Available"}}
					@else
					{{"Unavailable"}}
					@endif
                </td>
                <td class="text-center align-middle">
                	
                	<div class="d-inline-block">
                		<form method="POST" action="/assets/{{$asset->id}}">
                			@csrf
                			@method('DELETE')
                			@if($asset->isAvailable == 1)
                			<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Make Unavailable</button>
                			@else
                			<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-remove"></span> Make Available</button>
                			@endif
                		</form>
                	</div>
                </td>          
            </tr>
      	@endforeach
      </tbody>
    </table>
   {{--  {{ $assets->render() }} --}}
    </div>


@endsection