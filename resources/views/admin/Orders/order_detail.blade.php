@extends('layouts.adminLayout.admin_design')
@section('content')

<!--main-container-part-->
<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Orders</a> </div>
		<h1>Order #{{$orderDetail->id}}</h1>
		@include('layouts.adminLayout.session')
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span6">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
						<h5>Order Details</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<td class="taskDesc"><i class="icon-info-sign"></i> Order Date</td>
									<td class="taskStatus">{{$orderDetail->created_at}}</td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i> Order Status</td>
									<td class="taskStatus"><span class="pending">{{$orderDetail->order_status}}</span></td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i> Order Total</td>
									<td class="taskStatus"><span class="pending">Rs.{{$orderDetail->grand_total}}</span></td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i>Shipping Charges</td>
									<td class="taskStatus"><span class="pending">Rs.{{$orderDetail->shipping_charges}}</span></td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i> Coupon Code</td>
									<td class="taskStatus"><span class="pending">{{$orderDetail->coupon_code}}</span></td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i> Coupon Amount</td>
									<td class="taskStatus"><span class="pending">Rs.{{$orderDetail->coupon_amount}}</span></td>
									<tr>
										<td class="taskDesc"><i class="icon-plus-sign"></i> Payment Method</td>
										<td class="taskStatus"><span class="pending">{{$orderDetail->payment_method}}</span></td>
									</tr>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion" id="collapse-group">
					<div class="accordion-group widget-box">
						<div class="accordion-heading">
							<div class="widget-title"> 
								<h5>Billing Details</h5>
							</div>
						</div>
						<div class="collapse in accordion-body" id="collapseGOne">
							<div class="widget-content">
								<b>Name:</b> {{$userDetails->name}} <br>
								<b>Address:</b> {{$userDetails->address}} <br>
								<b>City:</b> {{$userDetails->city}} <br>
								<b>State:</b> {{$userDetails->state}} <br>
								<b>Country:</b> {{$userDetails->country}} <br>
								<b>Pincode:</b> {{$userDetails->pincode}} <br>
								<b>Mobile:</b> {{$userDetails->mobile}} <br>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
						<h5>Customer Details</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<td class="taskDesc"><i class="icon-info-sign"></i> Customer Name</td>
									<td class="taskStatus">{{$orderDetail->name}}</td>
								</tr>
								<tr>
									<td class="taskDesc"><i class="icon-plus-sign"></i> Customer Email </td>
									<td class="taskStatus"><span class="pending">{{$orderDetail->user_email}}</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion" id="collapse-group">
					<div class="accordion-group widget-box">
						<div class="accordion-heading">
							<div class="widget-title"> 
								<h5>Update Order Status</h5>
							</div>
						</div>
						<div class="collapse in accordion-body" id="collapseGOne">
							<div class="widget-content">
								<form action="{{url('/admin/update-order-status')}}" method="post">
									{{csrf_field()}}
									<input type="hidden" name="order_id" value="{{ $orderDetail->id }}">
									<table width="100%">
										<tr>
											<td>
												<select name="order_status" id="order_status" class="control-label" required="">
													<option value="New" @if($orderDetail->order_status=="New")selected @endif>New</option>
													<option value="Pending"@if($orderDetail->order_status=="Pending")selected @endif>Pending</option>
													<option value="Cancelled"@if($orderDetail->order_status=="Cancelled")selected @endif>Cancelled</option>
													<option value="In Procress"@if($orderDetail->order_status=="Procress")selected @endif>In Process</option>
													<option value="Shipped"@if($orderDetail->order_status=="Shipped")selected @endif>Shipped</option>
													<option value="Delivered"@if($orderDetail->order_status=="Delivered")selected @endif>Delivered</option>
													<option value="Paid"@if($orderDetail->order_status=="Paid")selected @endif>Paid</option>
												</select>
											</td>
											<td>
												<button type="submit" value="Update Status" class="btn btn-primary">Update</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="accordion" id="collapse-group">
					<div class="accordion-group widget-box">
						<div class="accordion-heading">
							<div class="widget-title"> 
								<h5>Shipping Details</h5>
							</div>
						</div>
						<div class="collapse in accordion-body" id="collapseGOne">
							<div class="widget-content">
								<b>Name:</b> {{$orderDetail->name}} <br>
								<b>Address:</b> {{$orderDetail->address}} <br>
								<b>City:</b> {{$orderDetail->city}} <br>
								<b>State:</b> {{$orderDetail->state}} <br>
								<b>Country:</b> {{$orderDetail->country}} <br>
								<b>Pincode:</b> {{$orderDetail->pincode}} <br>
								<b>Mobile:</b> {{$orderDetail->mobile}} <br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row-fluid">
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
</div>
<!--main-container-part-->


@endsection