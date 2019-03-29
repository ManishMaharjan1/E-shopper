@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{ url('/admin/view-product') }}">Coupons</a> <a href="#" class="current">Edit Coupon</a> </div>
    <h1>Coupons</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Coupon</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('/admin/edit-coupon/'.$coupondetails->id) }}" name="edit_coupon" id="edit_coupon">
              {{csrf_field()}}

              <div class="control-group">
                <label class="control-label">Coupon Code</label>
                <div class="controls">
                  <input type="text" name="coupon_code" id="coupon_code" value="{{$coupondetails->coupon_code}}" minlength="5" maxlength="10" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Amount</label>
                <div class="controls">
                  <input type="number" name="amount" id="amount" value="{{$coupondetails->amount}}" min="1" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"> Amount Type </label>
                <div class="controls">
                  <select name ="amount_type" id="amount_type" value="{{$coupondetails->amount_type}}" style="width:220px;">

                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>

                  </select>
                </div>
                <div class="control-group">
                  <label class="control-label">Expiry Date</label>
                  <div class="controls">
                    <input type="text" name="expiry_date" id="expiry_date" value="{{$coupondetails->expiry_date}}" autocomplete="off">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Enable Status</label>
                  <div class="controls">
                    <input type="checkbox" name="status" id="status" @if($coupondetails->status=="1")checked 
                  @endif value="1">
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Update Coupon" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

@endsection