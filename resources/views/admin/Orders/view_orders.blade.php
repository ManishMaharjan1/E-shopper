@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Products</a> <a href="#" class="current">View Products</a> </div>
		<h1>Orders</h1>
		@include('layouts.adminLayout.session')
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
						<h5>View Orders</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Order Date</th>
									<th>Customer Name</th>
									<th>Customer Email</th>
									<th>Ordered Product</th>
									<th>Order Quantity</th>
									<th>Order Amount</th>
									<th>Order Status</th>
									<th>Payment Method</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								{{-- @php 
								$i =1
								@endphp --}}
								@foreach($orders as  $order)
								<tr class="gradeX">
									<td>{{$order->id}}</td>
									<td>{{$order->created_at}}</td>
									<td>{{$order->name}}</td>
									<td>{{$order->user_email}}</td>
									<td>
										@foreach($order->orders as $item)
											{{$item->product_code}}<br>
										@endforeach
									</td>
									<td>
										@foreach($order->orders as $item)
											{{$item->product_qty}}<br>
										@endforeach
									</td>
									<td>{{$order->grand_total}}</td>
									<td>{{$order->order_status}}</td>
									<td>{{$order->payment_method}}</td>
	
									<td class="center" style="display: inline-flex;">
										<a target="_blank" href="{{url('admin/view-order/'.$order->id)}}" class="btn btn-success btn-mini" title="View Orders">View Order</a>

									</td>
									</tr>
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