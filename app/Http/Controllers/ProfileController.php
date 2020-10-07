<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        $validateData = $r->validate([
            'name'                      =>  'required',
            'email'                     =>  'required|email|unique:users,email,'.Auth::id()
         ]);
         Auth::user()->update([
            'name'      =>  $r->name,
            'email'     =>  $r->email
        ]);

        Session::flash('message', 'Profile Updated');
        return redirect(route('home'));
    }

    public function upload(Request $r){
        $uploaded = false;
        if($r->hasFile('avatar')){
            if(Storage::disk('public')->exists(Auth::user()->avatar)) 
                Storage::disk('public')->delete(Auth::user()->avatar);

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
