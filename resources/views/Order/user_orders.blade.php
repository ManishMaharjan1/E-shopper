@extends('layouts.frontLayout.front_design')
@section('contents')
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{url('/')}}">Home</a></li>
				<li class="active">Orders</li>
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
						<th>Order ID</th>
						<th>Ordered Item</th>
						<th>Payment Option</th>
						<th>Grand Total</th>
						<th>Ordered On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $userorder)
					<tr>
						<td>{{$userorder->id}}</td>
						<td>
							@foreach($userorder->orders as $item)
								<a href="{{url('/orders/'.$userorder->id)}}">{{$item->product_code}}</a><br>
								@endforeach
						</td>
						<td>{{$userorder->payment_method}}</td>
						<td>{{$userorder->grand_total}}</td>
						<td>{{$userorder->created_at}}</td>
						<td>View Details</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>

@endsection()