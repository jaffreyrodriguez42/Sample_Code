@extends('layouts.app')

@section('content')

@can('role_id')
	{{-- This is the part where only ADMIN can see --}}


	{{-- different table --}}

	<div class="card-header">
	     <h5>Product Lines</h5>
	</div>

	 <div class="card-body row col-md-12 custyle">
	 <table class="table table-striped custab">
	 <thead>
	 	<a href="categories/create" class="btn btn-primary btn-xs pull-right mt-3"><b>+</b> Add new product line</a>
	     <tr>
	         <th class="align-middle">Name</th>
	         <th class="align-middle">Description</th>
	         <th class="align-middle">Status</th>
	         <th class="text-center" colspan="2">Action</th>
	     </tr>
	 </thead>
	 <tbody>
	 	@foreach($categories as $category)
	         <tr>
	         	<td class="align-middle"><a href="/categories/{{$category->id}}">{{$category->name}}</a></td>
	             <td class="align-middle">{{$category->description}}</td>
	             <td class="align-middle">
	             	@if($category->isActive == 1)
	             	{{"Active"}}
	             	@else
	             	{{"Inactive"}}
	             	@endif
	             </td>
                   

	             <td colspan="4" class="text-center align-middle" >
	             	<a href="/categories/{{$category->id}}/edit" class="btn btn-warning pl-5 pr-5 d-inline-block">Edit</a>
	             	<div class="d-inline-block">
	             		<form method="POST" action="/categories/{{$category->id}}">
	             			@csrf
	             			@method('DELETE')
	             			@if($category->isActive == 1)
	             			<button type="submit" class="btn btn-danger pl-4 pr-4">Deactivate</button>
	             			@else
	             			<button type="submit" class="btn btn-success pl-4 pr-4">Reactivate</button>
	             			@endif
	             		</form>
	             	</div>
	             </td>
	         </tr>
	   	@endforeach
	   </tbody>
	 </table>
	{{ $categories->render() }}

	 </div>


@else
		
<!-- Header -->


	{{-- this is the category index for non admin --}}

	<header class="bg-primary text-center py-5 mb-4">
	  <div class="container">
	    <h1 class="font-weight-light text-white">Product Lines</h1>
	  </div>
	</header>

	
	<!-- Page Content -->
	<div class="container">
	  <div class="row">

	  	@foreach($categories as $category)
	    	@if($category->isActive == 1)
	    <div class="col-xl-3 col-md-6 mb-4 d-inline-block">
	      <div class="card border-0 shadow">
	        <img src="{{ asset($category->img_path) }}" class="card-img-top" alt="...">
	        <div class="card-body text-center">

	          <h5 class="card-title mb-0">{{ $category->name }}</h5>
	          <div class="card-text text-black-50">{{ $category->description }}</div>
	          <form method="POST" action="/transactions">
	          		@csrf
	          		<div class="card-text text-center">
	          				{{-- borrow dateinput --}}
	          			  <label for="borrowDate">Borrow Date:</label>
	          			  <p><input type="date" id="borrowDate" name="borrowDate"></p>
	          			  	{{-- return dateinput --}}
	          			  <label for="borrowDate">Return Date:</label>
	          			  <p><input type="date" id="returnDate" name="returnDate"></p>
	          			  {{-- <p><button class="btn btn-success" type="submit">Request</button></p> --}}
	          			  <p><input type="submit" name="request" value="Request" class="btn btn-success pl-5 pr-5"></p>
	          			  <input name="category_id" value="{{$category->id}}" hidden>
	          		</div>

	          </form>
	          	
	        </div>
	      </div>
	    </div>
	    	@endif

	    @endforeach
	   </div>
	   {{ $categories->render() }}
	</div>



	
		    
@endcan

@endsection