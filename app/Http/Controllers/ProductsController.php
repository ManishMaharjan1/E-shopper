<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Products;
use App\Category;
use App\ProductsAttribute;
use App\ProductImage;
use App\Coupon;
use App\Banner;
use App\Country;
use App\User;
use App\DeliveryAddresses;
use App\Order;
use App\OrdersProduct;
use Session;
use Auth;
use Image;
use DB;


class ProductsController extends Controller
{
	//Product CRUD Function//
	public function addProduct(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
			$products = new Products;
			$products->category_id = $data['category_id'];
			$products->product_name = $data['product_name'];
			$products->product_code = $data['product_code'];
			$products->product_color = $data['product_color'];
			if(!empty($data['description']))
			{
				$products->description = $data['description'];
			}
			else{
				$products->description ='';
			}

			if(!empty($data['care']))
			{
				$products->care = $data['care'];
			}
			else{
				$products->care ='';
			}

			$products->price = $data['price'];
			
			if($request->hasfile('image')){
				$image_tmp = Input::file('image');
				if($image_tmp->isValid()){
					$extension = $image_tmp->getClientOriginalExtension();
					$fileName = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/'.$fileName;
					$medium_image_path = 'images/backend_images/products/medium/'.$fileName;
					$small_image_path = 'images/backend_images/products/small/'.$fileName;

    				//Resize Images//
					Image::make($image_tmp)->save($large_image_path);
					Image::make($image_tmp)->fit(600,600)->save($medium_image_path);
					Image::make($image_tmp)->fit(300,300)->save($small_image_path);
					$products->image = $fileName;
				}
			}
			$products->save();
			return redirect('/admin/view-product')->with('flash_message_success', 'Products added Successfully');
		}  
		$categories = Category::where(["parent_id"=>0])->get();
		$categories_dropdown = "<option value='' selected disabled> Select</option>";
		foreach($categories as $cat){
			$categories_dropdown .= "<option value='".$cat->id."'>".$cat->category_name."</option>";
			$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
			foreach ($sub_categories as $sub_cat) {
				$categories_dropdown .="<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->category_name."</option>";

			// $subcateglevel = Category::where(['parent_id'=>$sub_cat->id])->get();
			// foreach($subcateglevel as $sub){
			// 	$categories_dropdown .="<option value = '".$sub->id."'>$nbsp;--&nbsp;--$nbsp;".$sub->category_name."</option>";
			// }
				$sub_category = Category::where(['parent_id'=>$sub_cat->id])->get();
				foreach($sub_category as $sublevels){
					$categories_dropdown .="<option value = '".$sublevels->id."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;".$sublevels->category_name."</option>";
				}
			}
		}
		return view('admin.products.add-product')->with(compact('categories_dropdown'));
	}

	public function viewProduct(){
		$products = Products::orderBy('id', 'DESC')->get();
		$products = json_decode(json_encode($products));
		foreach($products as $key=>$val){
			$category_name = Category::where(['id'=>$val->category_id])->first();
			$products[$key]->category_name = $category_name->category_name; 
		} 
		return view('admin.products.view_products')->with(compact('products'));
	}

	public function editProduct(Request $request, $id = null){
		if($request->isMethod('post')){
			$data = $request->all();

			if(empty($data['description']))
			{
				$data['description']='';
			}

			if(empty($data['care']))
			{
				$data['care']='';
			}

			if($request->hasfile('image')){
				$image_tmp = Input::file('image');
				if($image_tmp->isValid()){
					$extension = $image_tmp->getClientOriginalExtension();
					$fileName = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/'.$fileName;
					$medium_image_path = 'images/backend_images/products/medium/'.$fileName;
					$small_image_path = 'images/backend_images/products/small/'.$fileName;

    				//Resize Images//
					Image::make($image_tmp)->save($large_image_path);
					Image::make($image_tmp)->fit(600,600)->save($medium_image_path);
					Image::make($image_tmp)->fit(300,300)->save($small_image_path);

    				//$products->image = $filename; --}}//
				}
			}
			else if(!empty($data['current_image'])){
				$fileName = $data['current_image'];
			}
			else{
				$fileName = '';
			}
			// foreach($data['product_color'] as $key => $colors){

			Products::where(['id'=>$id])->update([
				'category_id'=>$data['category_id'],
				'product_name'=>$data['product_name'],
				'product_code'=>$data['product_code'],
				'product_color'=>$data['product_color'],
				'description'=>$data['description'],
				'care'=>$data['care'],
				'price'=>$data['price'],
				'image'=>$fileName]);
			return redirect()->back()->with('flash_message_success', 'Product updated Successfully');
		}
		$productdetails = Products::where(['id'=>$id])->first();
		$categories = Category::where(["parent_id"=>0])->get();
		$categories_dropdown = "<option value='' selected disabled> Select</option>";
		foreach($categories as $cat){
			if($cat->id==$productdetails->category_id){
				$select="selected";
			}
			else{
				$select="";
			}
			$categories_dropdown .= "<option value='".$cat->id."'".$select.">".$cat->category_name."</option>";
			$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
			foreach ($sub_categories as $sub_cat) {
				if($sub_cat->id==$productdetails->category_id){
					$select="selected";
				}
				else{
					$select="";
				}
				$categories_dropdown .="<option value = '".$sub_cat->id."'".$select.">&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
			}
		}
		return view('/admin.products.edit_products')->with(compact('productdetails','categories_dropdown'));
	}

	public function delProductImage($id){

		//Get Product Image Name//
		$productImage = Products::where(['id'=>$id])->first();

		//Get Product Image Path//
		$large_image_path = 'images/backend_images/products/large/';
		$medium_image_path = 'images/backend_images/products/medium/';
		$small_image_path = 'images/backend_images/products/small/';

		//Delete large image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/large/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/large/'. $productImage->image));
		}
		//Delete medium image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/medium/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/medium/'. $productImage->image));
		}
		//Delete small image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/small/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/small/'. $productImage->image));
		}

		//Products image deletion from table only// 
		Products::where(['id'=>$id])->update(['image'=>'']);
		return redirect()->back()->with('flash_message_success', 'Product image deleted Successfully!'); 
	}

	public function deleteProduct( $id=null){
		Products::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Product deleted Successfully');
	}

	//Product Attributes function//
	public function addAttributes(Request $request, $id = null){
		$productDetails = Products::with('attributes')->where(['id'=>$id])->first();
		// $productDetails = json_decode(json_encode($productDetails));
		// echo"<pre>"; print_r($productDetails); die; 
		if($request->isMethod('post')){
			$data = $request->all();
			// echo"<pre>"; print_r($data); die;
			foreach($data['sku'] as $key => $val){
				if(!empty($val)){
					$attrCountSKU = ProductsAttribute::where('sku', $val)->count();
					if($attrCountSKU>0){
						return redirect('admin/add-attributes/'.$id)->with('flash_message_error','SKU already exists! Please add another SKU!!');
					}

    				//product size duplication check//
					$attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
					if($attrCountSize>0){
						return redirect('admin/add-attributes/'.$id)->with('flash_message_error','"'.$data['size'][$key].'"Sizes already exists! Please add another size!!');
					}

					$attribute = new ProductsAttribute;
					$attribute->product_id = $id;
					$attribute->sku = $val;
					$attribute->size = $data['size'][$key];
					$attribute->price = $data['price'][$key];
					$attribute->stock = $data['stock'][$key];
					$attribute->save();
				}
			}

			return redirect('admin/add-attributes/'.$id)->with('flash_message_success','ProductsAttribute has been added Successfully!!!');
		}
		return view('admin.products.add_attributes')->with(compact('productDetails'));
	}

	public function editAttributes(Request $request, $id=null){
		if($request->isMethod('post')){
			$data = $request->all();
			foreach($data['idAttr'] as $key => $attr){
				ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
			}
			return redirect()->back()->with('flash_message_success',"Attributes Updated Sucessfully!!");
		}
	}
	
	public function deleteAttribute($id = null){
		ProductsAttribute::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Product Attribute deleted successfully');
	}

	//Front view dispaly listing function//
	public function products($url=null){

		//Show 404  page if category url doenot exist
		$countCategory = Category::where(['url'=>$url, 'status'=>1])->count();
		if($countCategory==0){
			abort(404);
		}

		//Get all categories and subcategories//
		$categories = Category::with('categories')->where(['parent_id'=>0])->get();
		$categorydetails= Category::where(['url'=>$url])->first();

		if($categorydetails->parent_id==0){
			//if url is main-category url
			$subCategories = Category::where(['parent_id'=>$categorydetails->id])->get();
			foreach($subCategories as $subcat){
				$cat_ids[] = $subcat->id;
			}
			$allProducts = Products::whereIn('category_id',$cat_ids)->get(); /*->where('status','1')*/
			
		}
		else{
			//if url is sub-category url
			$allProducts = Products::where(['category_id'=>$categorydetails->id])->get();
		}
		$banners = Banner::where('status','1')->get();
		return view('products.listing')->with(compact('categories','categorydetails','allProducts','banners'));			 
	}

	//Search Product Function//
	public function searchProducts(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			/*echo "<pre>"; print_r($data); die;*/

			$categories = Category::with('categories')->where(['parent_id'=>0])->get();

			$search_product = $data['product'];

			$allProducts = Products::where('product_name','like','%'.$search_product. '%')->orwhere('product_code',$search_product)->get();
			/*->where('status',1)*/
			return view('products.listing')->with(compact('categories','allProducts','search_product'));	
		}
	}

	//Product Function for detail page//
	public function product($id=null){

		//GEt Categories and sub categories//
		$categories = Category::with('categories')->where(['parent_id'=>0])->get();
		
		//Get Product Details//
		$productdetails = Products::with('attributes')->where(['id'=>$id])->first();
		// $productdetails = json_decode(json_encode($productdetails));
		// echo "<pre>"; print_r($productdetails); die;

		$relatedproduct = Products::where('id','!=',$id)->where(['category_id'=>$productdetails->category_id])->get();
		// $relatedproduct = json_decode(json_encode($relatedproduct));
		// echo "<pre>"; print_r($relatedproduct); die;

		//Get Product Alternate Image//
		$productAltImages = ProductImage::where(['product_id'=>$id])->get();
		// $productAltImages = json_decode(json_encode($productAltImages));
		// echo "<pre>"; print_r($productAltImages); die;

		// $sizes = ProductsAttribute::where(['product_id'=>$id])->first();
		// $colors = Products::where(['id'=>$id])->get();
		$total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

		return view('products.detail')->with(compact('productdetails', 'categories','productAltImages','total_stock','relatedproduct'));
	}

	//Get Product product price//
	public function Productprice(Request $request){
		$data = $request->all();
		// echo "<pre>"; print_r($data); die;//
		$proAtr = explode("-",$data['idSize']);
		// echo $proAtr[0]; echo $proAtr[1]; die;
		$proAtr = ProductsAttribute::where(['product_id'=>$proAtr[0], 'size'=>$proAtr[1]])->first();
		echo $proAtr->price; 
		echo "#";
		echo $proAtr->stock; 
	}

	//Alternate Image Function//
	public function addImage(Request $request, $id=null){
		
		$productDetails = Products::with('attributes')->where(['id'=>$id])->first();
		
		if($request->isMethod('post')){
			$data = $request->all();
			if($request->hasFile('image')){
				$files = $request->file('image');
				foreach($files as $file){
					$image = new ProductImage;
					$extension = $file->getClientOriginalExtension();
					$fileName = rand(111,99999).'.'.$extension;
					$large_image_path = 'images/backend_images/products/large/'. $fileName;
					$medium_image_path = 'images/backend_images/products/medium/'. $fileName;
					$small_image_path = 'images/backend_images/products/small/'. $fileName;
					Image::make($file)->save($large_image_path);
					Image::make($file)->resize(600,600)->save($medium_image_path);
					Image::make($file)->resize(300,300)->save($small_image_path);
					$image->image = $fileName;
					$image->product_id = $data['product_id'];
					$image->save();
				}
				
			}
			return redirect('admin/add-images/'.$id)->with('flash_message_success','Product Image added successfully');
		}
		$productImages = ProductImage::where(['product_id'=>$id])->get();

		return view('admin.products.add_images')->with(compact('productDetails','productImages'));
	}

	public function deleteAltImage($id=null){

		//Get Product Image Name//
		$productImage = ProductImage::where(['id'=>$id])->first();

		//Get Product Image Path//
		$large_image_path = 'images/backend_images/products/large/';
		$medium_image_path = 'images/backend_images/products/medium/';
		$small_image_path = 'images/backend_images/products/small/';

		//Delete large image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/large/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/large/'. $productImage->image));
		}
		//Delete medium image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/medium/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/medium/'. $productImage->image));
		}
		//Delete small image if not exists in folder//
		if (file_exists(public_path('images/backend_images/products/small/'. $productImage->image))){
			unlink(public_path('images/backend_images/products/small/'. $productImage->image));
		}

		//Products image deletion from table only// 
		ProductImage::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Product alternate image deleted Successfully!');
	}

	//Cart function//
	public function addtocart(Request $request){

		Session::forget('CouponAmount');
		Session::forget('CouponCode');

		$data = $request->all();
		// echo "<pre>";print_r($data); die;

		if(empty(Auth::User()->email)){
			$data['user_email']='';
		}else{
			$data['user_email'] = Auth::User()->email;
		}

		$session_id = Session::get('session_id');

		if(!isset($session_id)){
			$session_id = str_random(20);
			Session::put('session_id', $session_id);
		}

		if(empty($data['size'])){
            return redirect()->back()->with('flash_message_error','Please Provide Your Size ');
        }

		$size = explode("-",$data['size']);
		$getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'],'size'=>$size[1]])->first();
		
		$countproduct = DB::table('cart')->where(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'product_code'=>$getSKU->sku,'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$size[1],'session_id'=>$session_id])->count();
		// echo $countproduct; die;
		
		if($countproduct>0){
			return redirect()->back()->with('flash_message_error','Product already exists in cart');
		}
		else{

			DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'product_code'=>$getSKU->sku,'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$size[1],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
		}

		return redirect('cart')->with('flash_message_success','Products added to cart!');
	}

	public function cart(){
		if(Auth::check()){
			$user_email = Auth::User()->email;
			$usercart = DB::table('cart')->where(['user_email'=>$user_email])->get();
		}
		else{
			$session_id = Session::get('session_id');
			$usercart = DB::table('cart')->where(['session_id'=>$session_id])->get();
		}
		foreach($usercart as $key => $product){
			$productDetails = Products::where('id',$product->product_id)->first();
			$usercart[$key]->image = $productDetails->image;
		}
		// echo "<pre>"; print_r($usercart); die;
		return view('Products.cart')->with(compact('usercart'));
	}

	public function deleteCartItem($id=null){

		Session::forget('CouponAmount');
		Session::forget('CouponCode');

		DB::table('cart')->where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Product from cart deleted Successfully');
	}

	public function updateCartquantity($id=null, $quantity=null){

		Session::forget('CouponAmount');
		Session::forget('CouponCode');

		$getCartDetails = DB::table('cart')->where('id',$id)->first();
		$getAttributeStock = ProductsAttribute::where('sku',$getCartDetails->product_code)->first();
		echo $getAttributeStock->stock; 
		echo $update_quantity = $getCartDetails->quantity+$quantity;
		if($getAttributeStock->stock >= $update_quantity){
			DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
			return redirect('cart')->with('flash_message_success', 'Product quantity has been updated Successfully');			
		}
		else{
			return redirect('cart')->with('flash_message_error', ' Required product quantity is not available');	
		} 
	}

	public function applyCoupon(Request $request){
		Session::forget('CouponAmount');
		Session::forget('CouponCode');

		$data = $request->all();
		// echo "<pre>";print_r($data); die;
		$couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
		if($couponCount == 0){
			return redirect()->back()->with('flash_message_error','Coupon Code is not Valid');
		}
		else{

			$couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();
			//if coupon is inactive//
			if($couponDetails->status==0){
				return redirect()->back()->with('flash_message_error','Coupon Code is not active');
			}

			//If coupon is expired//
			$expiry_date = $couponDetails->expiry_date;
			$current_date = date('Y-m-d'); 
			if($expiry_date < $current_date){
				return redirect()->back()->with('flash_message_error','Coupon has been expired');
			}

			//Coupon is valid for discount//

			//Get cart total amount//
			$session_id = Session::get('session_id');

			if(Auth::check()){
			$user_email = Auth::User()->email;
			$usercart = DB::table('cart')->where(['user_email'=>$user_email])->get();
			}
			else{
				$session_id = Session::get('session_id');
				$usercart = DB::table('cart')->where(['session_id'=>$session_id])->get();
			}


			$total_amount = 0;
			foreach($usercart as $item){
				$total_amount = $total_amount + ($item->price * $item->quantity); 
			}

			//Check if amount type is fixed or percentage..//
			if($couponDetails->amount_type=="fixed"){
				$couponAmount = $couponDetails->amount;
			}
			else{
				$couponAmount = $total_amount * ($couponDetails->amount/100);   
			}

			//Add coupon amount in session//
			Session::put('CouponAmount',$couponAmount);
			Session::put('CouponCode',$data['coupon_code']);

			return redirect()->back()->with('flash_message_success', 'Coupon code is successfully applied. You are availing discount');
		}
	}

	public function checkout(Request $request){
		$user_id = Auth::User()->id;
		$user_email = Auth::User()->email;
		$userDetails = User::find($user_id);
		$getCountry = Country::get();

		//Update cart table with user email//
		$session_id = Session::get('session_id');
		DB::table('cart')->where(['session_id'=>$session_id])->update([ 'user_email'=>$user_email]);

		//Check if shipping address exits//
		$shippingCount = DeliveryAddresses::where('user_id',$user_id)->count();
		$shippingDetails = array();
		if($shippingCount>0){
			$shippingDetails = DeliveryAddresses::where('user_id',$user_id)->first();
		}

		if($request->isMethod('post')){
			$data = $request->all();
			// dump($data);
			//If ceheckout form are empty//
			if(empty($data['billing_name']) || empty($data['billing_address']) ||empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])){
				return redirect()->back()->with('flash_message_error','Please fill the all information field');
			}

			//Update User Details//
			User::where('id',$user_id)->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'], 'state'=>$data['billing_state'], 'country'=>$data['billing_country'], 'pincode'=>$data['billing_pincode'], 'mobile'=>$data['billing_mobile']]);

			if($shippingCount>0){
			//Update Shipping Address//
			DeliveryAddresses::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'], 'state'=>$data['shipping_state'], 'country'=>$data['shipping_country'], 'pincode'=>$data['shipping_pincode'], 'mobile'=>$data['shipping_mobile']]);
			}else{
			//Add new Shipping address//
			$shipping = new DeliveryAddresses;
			$shipping->user_id = $user_id;
			$shipping->user_email = $user_email;
			$shipping->name = $data['shipping_name'];
			$shipping->address =$data['shipping_address'];
			$shipping->city =$data['shipping_city'];
			$shipping->state =$data['shipping_state'];
			$shipping->country =$data['shipping_country'];
			$shipping->pincode =$data['shipping_pincode'];
			$shipping->mobile =$data['shipping_mobile'];
			$shipping->save();
			}
			return redirect()->action('ProductsController@orderReview');
		}
		return view('products.checkout')->with(compact('userDetails','getCountry','shippingDetails'));
	}

	//Order Review Function//
	public function orderReview(){
		$user_id = Auth::User()->id;
		$user_email = Auth::User()->email;
		$userDetails = User::where('id',$user_id)->first();
		$shippingDetails = DeliveryAddresses::where('user_id',$user_id)->first();
		// $shippingDetails = json_decode(json_encode($shippingDetails));
		$usercart = DB::table('cart')->where(['user_email'=>$user_email])->get();
		foreach($usercart as $key => $product){
			$productDetails = Products::where('id',$product->product_id)->first();
			$usercart[$key]->image = $productDetails->image;

		}
		// echo "<pre>"; print_r($usercart); die;
		return view('products.order_review',compact('userDetails','shippingDetails','usercart'));
	}

	//Order placement function//
	public function placeOrder(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			$user_id = Auth::User()->id;
			$user_email = Auth::User()->email;
			
			// Get Shipping Details//
			$shippingDetails = DeliveryAddresses::where(['user_email'=>$user_email])->first();

			if(empty(Session::get('CouponCode'))){
				$coupon_code = '';
			}else{
				 $coupon_code = Session::get('CouponCode');
			}
			if(empty(Session::get('CouponAmount'))){
				$coupon_amount = '';
			}else{
				 $coupon_amount = Session::get('CouponAmount');
			}

			$order = new Order;
			$order->user_id = $user_id;
			$order->user_email = $user_email;
			$order->name = $shippingDetails->name;
			$order->address = $shippingDetails->address;
			$order->city = $shippingDetails->city;
			$order->state = $shippingDetails->state;
			$order->country = $shippingDetails->country;
			$order->pincode = $shippingDetails->pincode;
			$order->mobile = $shippingDetails->mobile;
			$order->coupon_code = $coupon_code;
			$order->coupon_amount = $coupon_amount;
			$order->order_status = "New";
			$order->payment_method = $data['payment_method'];
			$order->grand_total = $data['grand_total'];
			$order->save();

			$order_id = DB::getPdo()->lastInsertId();
			$cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
			foreach($cartProducts as $prod){
				$cartpro = new OrdersProduct;
				$cartpro->order_id = $order_id;
				$cartpro->user_id = $user_id;
				$cartpro->product_id = $prod->product_id;
				$cartpro->product_code = $prod->product_code;
				$cartpro->product_color = $prod->product_color;
				$cartpro->product_name = $prod->product_name;
				$cartpro->product_size = $prod->size;
				$cartpro->product_price = $prod->price;
				$cartpro->product_qty = $prod->quantity;
				$cartpro->save();
			}
			Session::put('order_id',$order_id);
			Session::put('grand_total',$data['grand_total']);

			if($data['payment_method']=="COD"){
				$productdetails = Order::with('orders')->where('id',$order_id)->first();
				$productdetails = json_decode(json_encode($productdetails),true);
				// echo "<pre>"; print_r($productdetails); die;
				
				$userDetails = User::where('id',$user_id)->first();
				$userDetails = json_decode(json_encode($userDetails),true);
				// echo "<pre>"; print_r($userDetails); die;

				/* Code for Order Email Start */
				$email = $user_email;
				$messageData = [
					'email'=>$email,
					'name'=>$shippingDetails->name,
					'order_id'=>$order_id,
					'productdetails'=>$productdetails,
					'userDetails'=>$userDetails
				];
				Mail::send('email.order',$messageData,function($message) use($email){
					$message->to($email)->subject('Order Palced - E-shoppe Website');
				});
				/* Code for order Email Ends */

				//COD - Redirect user to Thanks Page after order//
				return redirect('/thanks');
			}else{
				//Paypal- Redirect Usr to paypal page//
				return redirect('/esewa');
			}
		}
	}

	public function thanksPage(){
		$user_email = Auth::User()->email;
		DB::table('cart')->where(['user_email'=>$user_email])->delete();
		return view('order.thanks');
	}

	//User order detail function//
	public function userOrder(){
		$user_id = Auth::User()->id;
		$orders = Order::with('orders')->where('user_id',$user_id)->get();
		// $orders = json_decode(json_encode($orders));
		// echo "<pre>"; print_r($orders); die;
		return view('order.user_orders',compact('orders'));
	}

	public function userOrderDetails($order_id){
		$user_id = Auth::User()->id;
		$orderDetail = Order::with('orders')->where('id',$order_id)->first();
		$orderDetail = json_decode(json_encode($orderDetail));
		// echo "<pre>"; print_r($OrderDetail); die;
		return view('order.order_detail',compact('orderDetail'));
	}

	//Order Function//
	public function viewOrder(){
		$orders = Order::with('orders')->latest()->get();
		$orders = json_decode(json_encode($orders));
		// echo "<pre>"; print_r($orders); die;
		return view('admin.orders.view_orders',compact('orders'));
	}

	//Order Detail in Admin//
	public function viewOrderDetail($order_id){
		$orderDetail = Order::with('orders')->where('id',$order_id)->first();
		$orderDetail = json_decode(json_encode($orderDetail));
		$user_id = $orderDetail->user_id;
		$userDetails = User::where('id',$user_id)->first();
		// $userDetails = json_decode(json_encode($userDetails));
		// echo "<pre>"; print_r($orderDetail); die;
		return view('admin.orders.order_detail',compact('orderDetail','userDetails'));
	}

	//Update order status function//
	public function updateOrderStatus(Request $request){
		if($request->isMethod('post')){
			$data = $request->all();
			Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
			return redirect()->back()->with('flash_message_success','Order Status has been updated successfully');
		}
	}

	//Payment Paypal function//
	public function Esewa(){
		$user_email = Auth::User()->email;
		DB::table('cart')->where(['user_email'=>$user_email])->delete();
		return view('order.esewa');
	}

}
