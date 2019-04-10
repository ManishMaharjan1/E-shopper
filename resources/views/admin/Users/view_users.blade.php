@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Users</a> <a href="#" class="current">View Users</a> </div>
		<h1>Users</h1>
		{{-- @include('layouts.adminLayout.session') --}}
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
						<h5>View Users</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>User Id</th>
									<th>Name</th>
									<th>Address</th>
									<th>City</th>
									<th>State</th>
									<th>Country</th>
									<th>Pincode</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Status</th>
									<th>Registered On</th>
								</tr>
							</thead>
							<tbody>
								{{-- @php 
								$i =1
								@endphp --}}
								@foreach($users as  $user)
								<tr class="gradeX">
									<td>{{$user->id}}</td>
									<td>{{$user->name}}</td>
									<td>{{$user->address}}</td>
									<td>{{$user->city}}</td>
									<td>{{$user->state}}</td>
									<td>{{$user->country}}</td>
									<td>{{$user->pincode}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->mobile}}</td>
									<td>
										@if($user->status==1)
											<span style="color: green">Active</span>
										@else
											<span style="color: red">Inactive</span>
										@endif
									</td>
									<td>{{$user->created_at}}</td>
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