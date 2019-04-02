<?php

namespace App\Http\Controllers;

use App\Logo;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logos = Logo::all();
        return view('admin.logo.logo',compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addLogo(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|mimes:jpeg,jpg,bmp,png',
        ]);
        $image = $request->file('image');
        // $slug = str_slug($request->name);
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

            if (!file_exists('images/logo'))
            {
                mkdir('images/logo',0777,true);
            }
            $image->move('images/logo',$imagename);
        }else{
            $imagename = "default.png";
        }
        $logo = new Logo();
        $logo->image = $imagename;
        $logo->save();
        return view('admin.logo.logo',compact('logo'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logo = logo::find($id);
        return view('admin.logo.edit',compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'image' => 'required|mimes:jpeg,jpg,bmp,png',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

            if (!file_exists('uploads/logo'))
            {
                mkdir('uploads/logo',0777,true);
            }
            $image->move('uploads/logo',$imagename);
        }else{
            $imagename = $logo->image;
        }
        $logo = Logo::find($id);
        $logo->image = $imagename;
        $logo->save();
        return redirect()->route('admin.logo.logo')->with('successMsg','Logo Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
