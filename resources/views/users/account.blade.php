@extends('layouts.frontLayout.front_design')
@section('contents')

<section id="form" style="margin-top: 20px;"><!--form-->
	<div class="container">
		<div class="row">
			@include('layouts.adminLayout.session')
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2>Update account</h2>
						<form id="accountForm" name="accountForm" action="{{url('/account')}}" method="post">
						{{csrf_field()}}
						<input value="{{$userDetails->name}}" type="text" id="name" name="name" placeholder="Name" />
						<input  value="{{$userDetails->address}}" type="text" name="address" id="address" placeholder="Address" />
						<input  value="{{$userDetails->city}}" type="text" name="city" id="city" placeholder="City" />
						<input  value="{{$userDetails->state}}" type="text" name="state" id="state" placeholder="State" />
						<select id="country" name="country">
							<option value="">Select Country</option>
							@foreach($countries as $country)
							<option value="{{$country->country_name}}" @if($country->country_name==$userDetails->country) selected @endif>{{$country->country_name}}</option>
							@endforeach
						</select>
						<input value="{{$userDetails->pincode}}" type="text" name="pincode" id="pincode" placeholder="Pincode(Optional)" style="margin-top: 10px;" />
						<input value="{{$userDetails->mobile}}"  type="text" name="mobile" id="mobile" placeholder="Mobile" />
						{{-- <span>
							<input type="checkbox" class="checkbox" style=""> 
							Keep me signed in
						</span> --}}
						<button type="submit" class="btn btn-default">Update Account</button>
					</form>
				</div><!--/login form-->
			</div>
			<div class="col-sm-1">
				<h2 class="or">OR</h2>
			</div>
			<div class="col-sm-4">
				<div class="signup-form"><!--sign up form-->
					<h2>Update Password</h2>
					<form id="passwordForm" name="passwoordForm" action="{{url('/update-user-pwd')}}" method="post">
						{{@csrf_field()}}
						<input type="password" id="current_pwd" name="current_pwd" placeholder="Current Password*"/>
						<span id="chkPwd"></span>
						<input type="password" id="new_pwd" name="new_pwd" placeholder="New Password*"/>
						<input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password*"/>
						<button type="submit" class="btn btn-default">Update Password</button>
					</form>
					
				</div><!--/sign up form-->
			</div>
		</div>
	</div>
</section><!--/form-->
@endsection
