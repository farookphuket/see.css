<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;

use Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function checkUserPassport(){
        $login = false;
        if(Auth::check()):
            $login = true;
        endif;
        return response()->json([
            "has_passport" => $login
        ]);
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
            "email" => ["required","email"],
            "password" => ["required"]
        ]);

        // return back data
        $name = '';
        $url = '';
        $token = '';
        if(!Auth::attempt($valid)):
            // login fail

            $msg = "<span class=\"has-text-danger 
            has-text-weight-bold\">Sorry,login fail!</span>";
            $url = '/login';
        else:
            // login true then set the session 
            $name = Auth::user()->name;
            $url = $this->userSetUrl();
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            $msg = "<span class=\"has-text-success has-text-weight-bold\">Welcome {$name}</span>";
        endif;



        return response()->json([
            "msg" => $msg,
            "url" => $url,
            "token" => $token
        ]);
    }

    public function userSetUrl(){
        $u = User::find(Auth::user()->id);

        $root = false;
        $member = false;

        $url = "/member-dashboard";

        if($u->is_admin != 0):
            $url = "/admin-dashboard";
            $root = true;
            Session::put("USER_IS_ADMIN",$root);
        else:
            $member = true;
            Session::put("USER_IS_MEMBER",$member);
        endif;

        return $url;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
