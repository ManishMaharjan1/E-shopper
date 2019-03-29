@extends('layouts.frontLayout.front_design')
@section('contents')

<section id="form" style="margin-top: 20px;"><!--form-->
	<div class="container">
		<form action="#">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Bill To</h2>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_name" id="billing_name" value="{{$userDetails->name}}" placeholder="Billing Name"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_address" id="billing_address" value="{{$userDetails->address}}" placeholder=" Billing Address" />
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_city" id="billing_city" value="{{$userDetails->city}}" placeholder="Billing City"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_state" id="billing_state" value="{{$userDetails->state}}" placeholder="Billing State"/>
						</div>
						<div class="form-group">
							<select id="billing_country" name="billing_country" class="form-control">
								<option value="">Select Country</option>
								@foreach($getCountry as $country)
								<option value="{{$country->country_name}}" @if($country->country_name==$userDetails->country) selected @endif>{{$country->country_name}}</option>
								@endforeach
							</select>

						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_pincode" id="billing_pincode" value="{{$userDetails->pincode}}" placeholder="Billing Pincode"/>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="billing_mobile" id="billing_mobile"billing_address value="{{$userDetails->mobile}}" placeholder="Billing Mobile"/>
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
								<input type="text" class="form-control" placeholder="Shipping Name"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder=" Shipping Address" />
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Shipping City"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Shipping State"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Shipping Country"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Shipping Pincode"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Shipping Mobile"/>
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