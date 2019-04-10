<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use App\User;
use App\Category;
use App\Products;
use App\Banner;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            $adminCount = Admin::where(['username'=>$data['username'],'password'=>md5($data['password']),'status'=>1])->count(); 
            if($adminCount >0){
                // echo "Success"; die;
                Session::put('adminSession',$data['username']);
                return redirect('/admin/dashboard');
            }
            else{
                // echo "failed"; die;
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }
        }

        return view('admin.admin_login');
    }
    
    public function dashboard(){
        // if(Session::has('adminSession')){
        //     //Perform all dashboard tasks
        // }
        // else {
        //     return redirect('/admin')->with('flash_message_error', 'Please login to access');
        // }

        $categories = Category::count();
        $products = Products::count();
        $banners = Banner::count();
        return view('admin.dashboard')->with(compact('categories','products','banners'));
    }

    public function settings(){
        $adminDetails = Admin::where(['username'=>Session::get('adminSession')])->first();
        // echo "<pre>"; print_r($adminDetails); die;
        return view('/admin.settings',compact('adminDetails'));
    }

    public function chkPassword(Request $request){
        $data = $request->all();
        // $current_password = $data['current_pwd'];
        // $check_password =  Admin::where(['username'=>Session::get('adminSession')])->first();
        $adminCount = Admin::where(['username'=>Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count(); 
        if($adminCount == 1){
            return "true";
        }
        else{
         return "false";
     }

 }

 public function updatePassword(Request $request){
    if($request->isMethod('post')){
        $data = $request->all();
            // 
            // $check_password = Admin::where(['email'=>Auth::user()->email])->first();
            // $current_password = $data['current_pwd']
            // ;

        $adminCount = Admin::where(['username'=>Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count(); 

        if($adminCount == 1){
           $password = md5($data['new_pwd']);
           Admin::where('username',Session::get('adminSession'))->update(['password'=>$password]);
           return redirect('/admin/settings')->with('flash_message_success', 'Password updated Successfully');
       }
       else{
        return redirect('/admin/settings')->with('flash_message_error', 'Incorrect Current Password');
    }
}
}

public function logout(){
    Session::flush();
    return redirect('/admin')->with('flash_message_success','Logged Out Successfully');
}

}

