@extends('layouts.frontLayout.front_design')
@section('contents')

<section id="form" style="margin-top: 20px;"><!--form-->
	<div class="container">
		<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Checkout</li>
				</ol>
			</div>
		@include('layouts.adminLayout.session')
		<form action="{{url('/checkout')}}" method="post" >
			{{csrf_field()}}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Bill To</h2>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{$userDetails->name}}"@endif placeholder="Billing Name"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{$userDetails->address}}" @endif placeholder=" Billing Address" />
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{$userDetails->city}}"@endif placeholder="Billing City"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{$userDetails->state}}"@endif placeholder="Billing State"/>
						</div>
						<div class="form-group">
							<select id="billing_country" name="billing_country" class="form-control">
								<option value="">Select Country</option>
								@foreach($getCountry as $country)
								<option value="{{$country->country_name}}" @if(!empty($userDetails->country) && $country->country_name==$userDetails->country) selected @endif>{{$country->country_name}}</option>
								@endforeach
							</select>

						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{$userDetails->pincode}}"@endif placeholder="Billing Pincode"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile))value="{{$userDetails->mobile}}"@endif placeholder="Billing Mobile"/>
						</div>
						<!-- Material unchecked -->
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="billship">
							<label class="form-check-label" for="billship">Shipping Address same as Billing Address</label>
						</div>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or"></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Ship To</h2>
						<form action="#">
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_name" id="shipping_name" placeholder="Shipping Name" @if(!empty($shippingDetails->name)) value="{{$shippingDetails->name}}"@endif />
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_address" id="shipping_address" placeholder=" Shipping Address"@if(!empty($shippingDetails->address)) value="{{$shippingDetails->address}}"@endif  />
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_city" id="shipping_city" placeholder="Shipping City" @if(!empty($shippingDetails->city)) value="{{$shippingDetails->city}}" @endif />
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_state" id="shipping_state" placeholder="Shipping State" @if(!empty($shippingDetails->state)) value="{{$shippingDetails->state}}" @endif />
							</div>
							<div class="form-group">
								<select id="shipping_country" name="shipping_country" class="form-control">
								<option value="">Select Country</option>
								@foreach($getCountry as $country)
								<option value="{{$country->country_name}}" @if(!empty($shippingDetails->country) && $country->country_name==$shippingDetails->country) selected @endif>{{$country->country_name}}</option>
								@endforeach
							</select>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_pincode" id="shipping_pincode" placeholder="Shipping Pincode" @if(!empty($shippingDetails->pincode)) value="{{$shippingDetails->pincode}}" @endif />
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="shipping_mobile" id="shipping_mobile" placeholder="Shipping Mobile" @if(!empty($shippingDetails->mobile)) value="{{$shippingDetails->mobile}}" @endif />
							</div>
							<button type="submit" class="btn btn-primary">Continue to Checkout</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</form>
	</div>
</section><!--/form-->

@endsection