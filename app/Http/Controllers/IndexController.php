<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Category;
use App\Banner;


class IndexController extends Controller
{

    public function index(){
    	
    	$allProducts = Products::inRandomOrder()->get();
    	//Get all categories and subcategories//
    	$categories = Category::with('categories')->where(['parent_id'=>0])->get();
        // $sub_cat = Category::with('categories')->where(['parent_id'=>0])->get();
        // $categories = json_decode(json_encode($categories));
    	// echo "<pre>"; print_r($categories); die;	
        $banners = Banner::where('status','1')->get();
	return view('index')->with(compact('allProducts','categories','sub_cat','banners'));
    }


}
