<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class ProfileController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function edit(){
        return view('user.edit')->with('user', Auth::user());
    }

    public function update(Request $r){

        if($r->hasFile('avatar')){
            dd($r->avatar->getClientOriginalName());
        }else{
            dd($r);
        }

        $validateData = $r->validate([
            'name'                      =>  'required',
            'email'                     =>  'required|email'
         ]);
         //$path = $r->file('avatar')->store('avatar');
         dump( request('avatar')->store('uploads', 'public') );
         dump($r->all());
        
    }

    public function upload(Request $r){
        $uploaded = false;
        if($r->hasFile('avatar')){
            $file = $r->avatar->store('avatar', 'public') ;
            Auth::user()->update([
                'avatar'=>$file
            ]);
            $uploaded = true;
        }
        if($uploaded)
            Session::flash('message', 'Image uploaded!');
        else
            Session::flash('message', 'Image could not be uploaded!');

        return redirect(route('user.edit'));
    }
}
