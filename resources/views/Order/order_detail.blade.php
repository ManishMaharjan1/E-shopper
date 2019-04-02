@extends('layouts.frontLayout.front_design')
@section('contents')
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a href="{{url('/orders')}}">Order</a></li>
				<li class="active"><b>Order ID:</b> 00{{$orderDetail->id}}</li>
			</ol>
		</div>
	</div>
</section>

<section id="do_action">
	<div class="container">
		<div class="heading" >
			<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Product Code</th>
						<th>Product Name</th>
						<th>Product Color</th>
						<th>Product Size</th>
						<th>Product Price</th>
						<th>Product Quantity</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orderDetail->orders as $pro)
					<tr>
						<td>{{$pro->product_code}}</td>
						<td>{{$pro->product_name}}</td>
						<td>{{$pro->product_color}}</td>
						<td>{{$pro->product_size}}</td>
						<td>{{$pro->product_price}}</td>
						<td>{{$pro->product_qty}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>

@endsection()