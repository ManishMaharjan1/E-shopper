<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Banner;
use Image;

class BannerController extends Controller
{
    
    public function addBanner(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();

    		$banners = new Banner;
    		$banners->title = $data['title'];
    		$banners->link = $data['link'];
    		if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
    		$banners->status = $status;
    		if($request->hasfile('image')){
				$image_tmp = Input::file('image');
				if($image_tmp->isValid()){
					$extension = $image_tmp->getClientOriginalExtension();
					$filename = rand(111,99999).'.'.$extension;
					$banner_path = 'images/banner/'.$filename;

    				//Resize Images//
					Image::make($image_tmp)->fit(1140,340)->save($banner_path);

					$banners->image = $filename;
				}
			}
    		$banners->save();
    		return redirect()->action('BannerController@viewBanner')->with('flash_message_success', 'Banner has been added Successfully');
    	}
    	return view('admin.banners.add_banner',compact('banners'));
    }

    public function viewBanner(){
    	$banners = Banner::get();
    	return view('admin.banners.view_banner')->with(compact('banners'));
    }

    public function editBanner(Request $request, $id=null){
    	if($request->isMethod('post')){
    		$data=$request->all();

    		if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            if(empty($data['title'])){
            	$title = '';
            }

            if(empty($data['link'])){
            	$link = '';
            }

    		if($request->hasfile('image')){
				$image_tmp = Input::file('image');
				if($image_tmp->isValid()){
					$extension = $image_tmp->getClientOriginalExtension();
					$filename = rand(111,99999).'.'.$extension;
					$banner_path = 'images/banner/'.$filename;
    				//Resize Images//
					Image::make($image_tmp)->fit(1140,340)->save($banner_path);
				}
			}
			else if(!empty($data['current_image'])){
					$filename = $data['current_image'];
			}
			else{
					$filename = '';
				}
				Banner::where('id',$id)->update([
					'status'=>$status,
					'title'=>$data['title'],
					'link'=>$data['link'],
					'image'=>$filename ]);
				return redirect()->action('BannerController@viewBanner')->with('flash_message_success', 'Banner has been updated Successfully!!');
			}
    		$bannerDetails = Banner::where(['id'=>$id])->first();
    		return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
   	}

   	public function deleteBanner($id=null){
   		Banner::where(['id'=>$id])->delete();
		return redirect()->back()->with('flash_message_success', 'Banner deleted Successfully');
   	}
}
