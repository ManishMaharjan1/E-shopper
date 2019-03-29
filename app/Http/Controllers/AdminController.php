<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
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
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>'1'])){
                // echo "Success"; die;
                // Session::put('adminSession',$data['email']);
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
        return view('/admin.settings');
    }

    public function chkPassword(Request $request){
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where(['id'=>$user_id])->first();
        if(Hash::check($current_password,$check_password->password)){
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
            $check_password = User::where(['email'=>Auth::user()->email])->first();
            $current_password = $data['current_pwd']
            ;
            if(Hash::check($current_password,$check_password->password)){
             $password = bcrypt($data['new_pwd']);
             User::where('id','1')->update(['password'=>$password]);
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

