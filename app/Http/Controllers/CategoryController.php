<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

    public function addCategory(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		// echo "<pre>"; print_r($data); die;
    		$category = new Category;
    		$category->category_name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            if(!empty($data['description']))
            {
                $category->description = $data['description'];
            }
            else{
                $category->description ='';
            }
            // $category->description = $data['description'];
            $category->url = $data['url'];

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $category->status = $status;
            $category->save();
            return redirect('/admin/view-category')->with('flash_message_success', 'Category added Successfully');
        }

        //code for subcategories of main category//
        $levels = Category::where(['parent_id'=>0])->get();
        // $sublevels = Category::where(['parent_id'=>$levels])->get();

        // $categories = Category::where(["parent_id"=>0])->get();
        // $categories_dropdown = "<option value='' selected disabled> Select</option>";
        //     foreach($categories as $cat){
        //         $categories_dropdown .= "<option value='".$cat->id."'>".$cat->category_name."</option>";
        //         $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
        //         foreach ($sub_categories as $sub_cat) {
        //             $categories_dropdown .="<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->category_name."</option>";

            // $subcateglevel = Category::where(['parent_id'=>$sub_cat->id])->get();
            // foreach($subcateglevel as $sub){
            //  $categories_dropdown .="<option value = '".$sub->id."'>$nbsp;--&nbsp;--$nbsp;".$sub->category_name."</option>";
            // }

        return view('admin.category.add_category')->with(compact('levels'));
    }

    public function viewCategory(){
      $categories = Category::get();
     
      $categories  =json_decode(json_encode($categories));
      $parentCategories = Category::where(['parent_id'=>0])->get();
      // $sub_categories = Category::where(['parent_id'=>$categories->id])->get();
      return view('admin.category.view_category')->with(compact('categories','parentCategories'));
  }

    public function editCategory(Request $request, $id = null){
        if ($request->isMethod('post')) {
            $data = $request->all();

        // if(!empty($data['description']))
        //     {
        //         $category->description = $data['description'];
        //     }
        //     else{
        //         $category->description ='';
                

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }


        Category::where(['id'=>$id])->update([
            'category_name'=>$data['category_name'],
            'description'=>$data['description'],
            'url'=>$data['url'],
            'status'=>$status]);
        return redirect('/admin/view-category')->with('flash_message_success', 'Category updated Successfully');
    }
    $categorydetails = Category::where(['id'=>$id])->first();
    $levels = Category::where(['parent_id'=>0])->get();

    return view('/admin.category.edit_category')->with(compact('categorydetails','levels'));
}

public function deleteCategory(Request $request, $id=null){
    
    if(!empty($id)){
        Category::where(['id'=>$id])->delete();
        return redirect()->back();
    }
}

}
