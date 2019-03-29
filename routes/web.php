<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', function(){
// 	return view('welcome');
// });
 

//Admin Login//
Route::match(['get','post'],'/admin','AdminController@login'); //Admin Login//

Auth::routes();

//Home Page//
Route::get('/', 'IndexController@index');

Route::get('/home', 'HomeController@index')->name('home');

//Listing Pages//
Route::get('/products/{url}','ProductsController@products');

//Product detail page//
Route::get('/product/{id}','ProductsController@product');

//Get Product Attribute Price//
Route::get('/get-product-price','ProductsController@Productprice')->name('productprice');

//Cart//
Route::match(['get','post'],'/add-cart','ProductsController@addtocart');
Route::match(['get','post'],'/cart','ProductsController@cart');
Route::get('/cart/delete-product/{id}','ProductsController@deleteCartItem');
Route::get('/cart/update-quantity/{id}/{quantity}','ProductsController@updateCartquantity');

//Apply Coupon//
Route::post('/cart/apply-coupon','ProductsController@applyCoupon');

//User Login-Register//
Route::get('/login-register','UserController@userLoginRegister');

//User Register form//
Route::post('/user-register','UserController@register');

//Check if user already exists//
Route::match(['get','post'],'/check-email','UserController@checkEmail');

//User Login//
Route::post('/user-login','UserController@login');

//User Logout//
Route::get('/user-logout','UserController@logout');

//User Middleware//
Route::group(['middleware'=>['frontlogin']],function(){

//User Account Function//
	Route::match(['get','post'],'/account','UserController@account');

	//User Current password check//
	Route::get('/check-user-pwd','UserController@chkUserPassword');
	
	//User password update//
	Route::post('/update-user-pwd','UserController@updateUserPassword');

	//Checkout//
	Route::match(['get','post'],'/checkout','ProductsController@checkout');

});


//Admin Route//
Route::group(['middleware'=>['auth']],function(){
	Route::get('/admin/dashboard','AdminController@dashboard');
	Route::get('/admin/settings','AdminController@settings');
	Route::get('/admin/check-pwd','AdminController@chkPassword');
	Route::match(['get', 'post'], '/admin/update-pwd','AdminController@updatePassword');

//Category(Admin)//
	Route::match(['get', 'post'], '/admin/add-category','CategoryController@addCategory');
	Route::match(['get', 'post'], '/admin/edit-category/{id}','CategoryController@editCategory');
	Route::match(['get', 'post'], '/admin/view-category','CategoryController@viewCategory');
	Route::get( '/admin/delete-category/{id}','CategoryController@deleteCategory');

//Product(Admin)//
	Route::match(['get', 'post'], '/admin/add-product','ProductsController@addProduct');
	Route::match(['get', 'post'], '/admin/edit-product/{id}','ProductsController@editProduct');
	Route::match(['get','post'], 'admin/view-product', 'ProductsController@viewProduct');
	Route::get('/admin/delete-product-image/{id}','ProductsController@delProductImage');
	Route::get('/admin/delete-product/{id}','ProductsController@deleteProduct');

//Product Attribute//

	Route::match(['get','post'], '/admin/add-attributes/{id}','ProductsController@addAttributes');
	Route::match(['get','post'],'admin/edit-attributes/{id}','ProductsController@editAttributes');
	Route::match(['get','post'], '/admin/add-images/{id}','ProductsController@addImage');
	Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteAltImage');
	Route::get('/admin/delete-attribute/{id}','ProductsController@deleteAttribute');

//Coupon//
	Route::match(['get','post'],'/admin/add-coupon','CouponController@addCoupon');
	Route::get('/admin/view-coupons', 'CouponController@viewCoupon');
	Route::match(['get','post'],'/admin/edit-coupon/{id}','CouponController@editCoupon');
	Route::get('/admin/delete-coupon/{id}','CouponController@deleteCoupon');

//Admin Banners//
	Route::match(['get','post'], '/admin/add-banner','BannerController@addBanner');
	Route::get('/admin/view-banners','BannerController@viewBanner');
	Route::match(['get','post'],'/admin/edit-banner/{id}','BannerController@editBanner');
	Route::get('../admin/delete-banner/{id}','BannerController@deleteBanner');

});

//AdminLogout//
Route::get('/logout','AdminController@logout');  



