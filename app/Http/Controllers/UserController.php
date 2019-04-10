<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Country;
use DB;
use Auth;
use Session;
class UserController extends Controller
{

    public function userLoginRegister(){

        return view('users.login_register');
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
    		// echo "<pre>"; print_r($data); die;

    		//Check user already exits or not//
            $userCount = User::where('email',$data['email'])->count(); 
            if($userCount>0){
             return redirect()->back()->with('flash_message_error','Email already exists');
            }else{
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();

               //Send Confirmation Email//
                $email = $data['email'];
                $messageData = ['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('email.confirmation',$messageData,function($message) use($email){
                    $message->to($email)->subject("Confirm Your Account for E-Shopper Website");
                });
                return redirect()->back()->with('flash_message_success','Please Confirm your email to login!');

               //Send Registration Email//
               // $email = $data['email'];
               // $messageData = ['email'=>$data['email'],'name'=>$data['name']];
               // Mail::send('email.register',$messageData,function($message) use($email){
               //  $message->to($email)->subject("Registration with E-Shopper Website");
               // });

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);
                        if(!empty(Session::get('session_id'))){
                        $session_id = Session::get('session_id');
                        DB::table('cart')->where('session_id',$session_id)->update(['user_email'=>$data['email']]);
                    }
                    return redirect('/cart');
                }
            }
        }
    }   

    public function confirmAccount($email){
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount > 0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                return redirect('login-register')->with('flash_message_success','Your User account is already activate. You can now login');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                //Send Welcome Email//
                $messageData = ['email'=>$email,'name'=>$userDetails->name];
                Mail::send('email.welcome',$messageData,function($message) use($email){
                    $message->to($email)->subject("Welcome to E-Shoppe");
                });
                return redirect('login-register')->with('flash_message_success','Your User account is activate. You can now login');
            }
        }else{
            abort(404);
        }
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
        		// echo "<pre>"; print_r($data); die;
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $userStatus = User::where('email',$data['email'])->first();
                if($userStatus->status == 0){
                return redirect()->back()->with('flash_message_error','Your Account has not been activated! Please confirm your email to login');
                }
            Session::put('frontSession',$data['email']);

            if(!empty(Session::get('session_id'))){
                $session_id = Session::get('session_id');
                DB::table('cart')->where('session_id',$session_id)->update(['user_email'=>$data['email']]);
            }
            return redirect('/cart');
            }else{
                return redirect()->action('UserController@userLoginRegister')->with('flash_message_error','Invalid email and password');
            }   
        }
    }

    public function checkEmail(Request $request){
    	//Check user already exits or not//
        $data = $request->all();
        $userCount = User::where('email',$data['email'])->count(); 
        if($userCount>0){
            echo "false";
        }else{
            echo "true"; die;
        }
    }

    public function account(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id); 
        $countries = Country::get();

        if($request->isMethod('post')){
            $data = $request->all();
                // echo "<pre>"; print_r($data); die;
            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success','User Detail Updated Successfully! ');
        }
        return view('users.account',compact('countries','userDetails'));
    }

    public function chkUserPassword(Request $request){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id',$user_id)->first();
            // dd($current_password);
        if(Hash::check( $current_password, $check_password->password)){
            return "true"; 
        }
        else{
            return "false";
        }
    }

    public function updateUserPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $old_pwd = User::where('id',Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd,$old_pwd->password)){
                //Update password//
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success'," Password is updated successfully");
            }else{
                return redirect()->back()->with('flash_message_error',"Current Password is incorrect");
            }
        }
    }

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function viewUsers(){
        $users = User::get();
        return view('admin.users.view_users',compact('users'));
    }
}