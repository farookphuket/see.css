<?php

namespace App\Http\Controllers;

use App\Models\Whatup;
use Illuminate\Http\Request;

use Auth;

class WhatupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $whatup = $this->getWhatup();

        return response()->json([
            "whatup" => $whatup
        ]);
    }

    public function getWhatup(){
        $perpage = request()->perpage;
        $root = Auth::user()->is_admin;
        $wp = '';
        
        if(Auth::user()):
            $wp = Whatup::where('is_public','!=',0)
            ->orWhere('user_id',Auth::user()->id)
            ->latest()
            ->paginate($perpage);
        elseif(Auth::user() && $root == 1):
            // admin 
            $wp = Whatup::latest()
            ->paginate($perpage);
        else:
            
            $wp = Whatup::where('is_public','!=',0)
            ->latest()
            ->paginate($perpage);
        endif;

        return $wp;

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
    public function store()
    {
        $valid = request()->validate([
            "wp_title" => ["required","min:8"],
            "wp_excerpt" => ["required","min:14"],
            "wp_body" => ["required","min:14"],
        ],[
            "wp_title.required" => "Error! title is required.",
            "wp_title.min" => "Error! title is too short.",
            "wp_excerpt.required" => "Error! the excerpt field required ",
            "wp_excerpt.min" => "Error! the excerpt field required ",
        ]);


        // cover image 
        $cover = $this->makeCover();

        // prepare data to create 
        $valid["user_id"] = Auth::user()->id;
        $valid["wp_title"] = xx_clean(request()->wp_title);
        $valid["wp_excerpt"] = xx_clean(request()->wp_excerpt);
        $valid["wp_body"] = xx_clean(request()->wp_body);
        $valid["is_public"] = request()->is_public?1:0;
        $valid["wp_cover"] = $cover;

        // create whatup
        Whatup::create($valid);

        $msg = "<span class=\"has-text-weight-bold has-text-success\">
Success your post has been save</span>";

        return response()->json([
            "msg" => $msg
        ]);
    }

    public function makeCover($id=false){
        $file_name = "/USER_UPLOAD/no_image.jpeg";

        // image url 
        $img_url = request()->wp_img_url;
        // upload to folder 
        $upload_to_folder = public_path("USER_UPLOAD/WP");

        $old_cover = "";
        if($id != false):
            // edit case
            $wp = Whatup::find($id);
            $old_cover = $wp->wp_cover;

            // upload file 
            if(request()->hasFile('wp_file_upload')):
                $new_name = Auth::user()->email."_";
                $new_name .=  date("Y-m-d")."_"; 
                $new_name .= request()->file('wp_file_upload')
                                      ->getClientOriginalName();

                // move upload file to upload folder 
                request()->file('wp_file_upload')
                         ->move($upload_to_folder,$new_name);

                // set upload file name 
                $file_name = "/USER_UPLOAD/WP/".$new_name;

                // delete the old file 
                unlink(public_path($old_cover));
            endif;

            // url image
            if(filter_var($img_url,FILTER_VALIDATE_URL)):
                $file_name = $img_url;
            endif;

        else:
            // create case 

            // upload file 
            if(request()->hasFile('wp_file_upload')):
                $new_name = Auth::user()->email."_";
                $new_name .=  date("Y-m-d")."_"; 
                $new_name .= request()->file('wp_file_upload')
                                      ->getClientOriginalName();

                // move upload file to upload folder 
                request()->file('wp_file_upload')
                         ->move($upload_to_folder,$new_name);

                // set upload file name 
                $file_name = "/USER_UPLOAD/WP/".$new_name;
            endif;

            // url image
            if(filter_var($img_url,FILTER_VALIDATE_URL)):
                $file_name = $img_url;
            endif;

        endif;

        return $file_name;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Whatup  $whatup
     * @return \Illuminate\Http\Response
     */
    public function show(Whatup $whatup)
    {
        $wp = Whatup::find($whatup->id);

        return response()->json([
            "whatup" => $wp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whatup  $whatup
     * @return \Illuminate\Http\Response
     */
    public function edit(Whatup $whatup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Whatup  $whatup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Whatup $whatup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whatup  $whatup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Whatup $whatup)
    {
        //
    }
}
