@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Coupons</a> <a href="#" class="current">View Coupons</a> </div>
		<h1>Coupons</h1>
		@include('layouts.adminLayout.session')
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
						<h5>View Coupons</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Coupon ID</th>
									<th>Coupon Code</th>
									<th>Amount</th>
									<th>Amount Type</th>
									<th>Expiry Date</th>
									<th>Created Date</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php 
								$i =1
								@endphp
								@foreach($coupons as $coupon)
								<tr class="gradeX">
									<td>{{$i++}}</td>
									<td>{{$coupon->coupon_code}}</td>
									<td>
										@if($coupon->amount_type=="fixed")
										 	Rs.{{$coupon->amount}}
									 	@else
											{{$coupon->amount}}% 
										@endif
									</td>
									<td>{{$coupon->amount_type}}</td>
									<td>{{$coupon->expiry_date}}</td>
									<td>{{$coupon->created_at}}</td>
									<td>
										@if($coupon->status==1) 
											Active
										@else
											Inactive
										@endif
									</td>
									<td class="center" style="">
										<a href="{{ url('/admin/edit-coupon/'. $coupon->id) }}" class="btn btn-primary btn-mini" title="Edit Coupons">Edit</a>
										<a rel="{{$coupon->id}}" rel1="delete-coupon" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
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
@endsection


