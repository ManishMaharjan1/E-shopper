@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-bannerss') }}">Banners</a> <a href="#" class="current">View Banners</a> </div>
		<h1>Banners</h1>
		@include('layouts.adminLayout.session')
	</div>
	<div class="container-fluid">
		<hr>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
						<h5>View Banners</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Banner ID</th>
									<th>Banner Title</th>
									<th>Banner Link</th>
									<th>Image</th>
									<th>Created Date</th>
									<th>Banner Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@php 
								$i =1
								@endphp
								@foreach($banners as  $banner)
								<tr class="gradeX">
									<td>{{$i++}}</td>
									<td>{{$banner->title}}</td>
									<td>{{$banner->link}}</td>
									<td style="width: 200px;">
										@if(!empty($banner->image))
										<img src="{{ asset('/images/banner/'. $banner->image) }}">
										@endif
									</td>
									<td>{{$banner->created_at}}</td>
									<td>
										@if($banner->status==1) 
											Active
										@else
											Inactive
										@endif
									</td>
									<td class="center" style="display: inline-flex;">
										<a  href="{{ url('/admin/edit-banner/'. $banner->id) }}" class="btn btn-primary btn-mini" title="Edit Products" style="margin-left: 4px;">Edit</a>
										<a rel="{{$banner->id}}" rel1="delete-product" <?php /* href="{{url('/admin/delete-product/'. $product->id)}}"*/ ?> href="javascript:" class="btn btn-danger btn-mini deleteRecord " style="margin-left: 4px;">Delete</a></td>
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