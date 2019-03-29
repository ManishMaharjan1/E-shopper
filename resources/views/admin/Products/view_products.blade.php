@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Products</a> <a href="#" class="current">View Products</a> </div>
		<h1>Products</h1>
		@include('layouts.adminLayout.session')
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
						<h5>View Products</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Product ID</th>
									<th>Category ID</th>
									<th>Category Name</th>
									<th>Product Name</th>
									<th>Product Code</th>
									<th>Product Color</th>
									<th>Description</th>
									<th>Price</th>
									<th>Image</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@php 
								$i =1
								@endphp
								@foreach($products as  $product)
								<tr class="gradeX">
									<td>{{$i++}}</td>
									<td>{{$product->category_id}}</td>
									<td>{{$product->category_name}}</td>
									<td>{{$product->product_name}}</td>
									<td>{{$product->product_code}}</td>
									<td>{{$product->product_color}}</td>
									<td>{{$product->description}}</td>
									<td>{{$product->price}}</td>
									<td>
										@if(!empty($product->image))
										<img src="{{ asset('/images/backend_images/products/small/'. $product->image) }}" style="width: 60px;">
										@endif
									</td>
									<td class="center" style="display: inline-flex;"><a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" title="View Products">View</a>
										<a  href="{{ url('/admin/edit-product/'. $product->id) }}" class="btn btn-primary btn-mini" title="Edit Products" style="margin-left: 4px;">Edit</a>
										<a href="{{ url('/admin/add-attributes/'. $product->id) }}" class="btn btn-success btn-mini" title="Add Attributes" style="margin-left: 4px;">Add</a>
										<a href="{{ url('/admin/add-images/'. $product->id) }}" class="btn btn-info btn-mini" title="Add Images" style="margin-left: 4px;">Add</a>
										<a rel="{{$product->id}}" rel1="delete-product" <?php /* href="{{url('/admin/delete-product/'. $product->id)}}"*/ ?> href="javascript:" class="btn btn-danger btn-mini deleteRecord " style="margin-left: 4px;">Delete</a></td>
									</tr>
									<div id="myModal{{$product->id}}" class="modal hide">
										<div class="modal-header">
											<button data-dismiss="modal" class="close" type="button">×</button>
											<h3>{{$product->product_name}}|| Full Details</h3>
										</div>
										<div class="modal-body">
											<p>Product ID: {{$product->id}}</p>
											<p>Category Name: {{$product->category_name}}</p>
											<p>Product Name: {{$product->product_name}}</p>
											<p>Product Code: {{$product->product_code}}</p>
											<p>Product Color: {{$product->product_color}}</p>
											<p>Product Description: {{$product->description}}</p>
										</div>
									</div>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection()