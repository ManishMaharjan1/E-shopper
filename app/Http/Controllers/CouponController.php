<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponController extends Controller
{
	//Add Copuon Function//
    public function addCoupon(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

    		$coupon = new Coupon;
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount = $data['amount'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		$coupon->status = $status;
    		$coupon->save();
    		return redirect()->action('CouponController@viewCoupon')->with('flash_message_success', 'Coupon added Successfully');
    	}
    	return view('admin.coupons.add_coupon')->with(compact('coupon'));
    }

    //View Coupon Function//
    public function viewCoupon(){
    	$coupons = Coupon::get();
    	return view('admin.coupons.view_coupon')->with(compact('coupons'));
    }

    //Edit Coupon Function//
    public function editCoupon(Request $request, $id=null){
    	if($request->isMethod('post')){
    		$data = $request->all();

    		 if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

    		Coupon::where(['id'=>$id])->update([
    			'coupon_code'=>$data['coupon_code'],
    			'amount'=>$data['amount'],
    			'amount_type'=>$data['amount_type'],
    			'expiry_date'=>$data['expiry_date'],
    			'status'=>$status]);
			return redirect()->action('CouponController@viewCoupon')->with('flash_message_success', 'Coupon updated Successfully');
    	}
    	 $coupondetails =Coupon::where(['id'=>$id])->first();
    	return view('admin.coupons.edit_coupon')->with(compact('coupondetails'));
    }

    //Delete Coupon Function//
    public function deleteCoupon($id=null){
    	Coupon::where(['id'=>$id])->delete();
    	return redirect()->back();
    }
}

		