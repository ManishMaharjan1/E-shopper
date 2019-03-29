<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Products;
use App\Category;
use App\ProductsAttribute;
use App\ProductImage;
use App\Coupon;
use App\Banner;
use App\Country;
use App\User;
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
			$allProducts = Products::whereIn('category_id',$cat_ids )->get();
			
		}
		else{
			//if url is sub-category url
		$allProducts = Products::where(['category_id'=>$categorydetails->id])->get();
		}
		$banners = Banner::where('status','1')->get();
		return view('products.listing')->with(compact('categories','categorydetails','allProducts','banners'));			 
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

		if(empty($data['user_email'])){
			$data['user_email']='';
		}
		$session_id = Session::get('session_id');

		if(empty($session_id)){
		$session_id = str_random(20);
		Session::put('session_id', $session_id);
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
		$session_id = Session::get('session_id');
		$usercart = DB::table('cart')->where(['session_id'=>$session_id])->get();
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
			$current_date = date('y-m-d'); 
			if($expiry_date<$current_date){
				return redirect()->back()->with('flash_message_error','Coupon has been expired');
			}

			//Coupon is valid for discount//

			//Get cart total amount//
			$session_id = Session::get('session_id');
			$usercart = DB::table('cart')->where(['session_id'=>$session_id])->get();
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

	public function checkout(){
		$user_id = Auth::User()->id;
		$userDetails = User::find($user_id);
		$getCountry = Country::get();
		return view('products.checkout')->with(compact('userDetails','getCountry'));
	}
}
  