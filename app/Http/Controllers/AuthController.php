<?php

namespace Chatter\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Chatter\Http\Requests;
use Chatter\User;

class AuthController extends Controller
{
    public function getSignUp(){
    return view('auth.signup');
    }

    public function postSignUp(Request $request){
      $this->validate($request,[
            'email'=>'required|email|unique:users|max:255',
            'username'=>'required|unique:users|alpha_dash|max:25',
            'password'=>'required|min:6',
      ]);

        User::create([
            'email'=>$request->input('email'),
            'username'=>$request->input('username'),
            'password'=>bcrypt($request->input('password')),
        ]);

        return redirect()->route('home')->with('info','Your account has been created!');
    }
    public function getSignIn(){
        return view('auth.signin');
    }

    public function postSignIn(Request $request){
        $this->validate($request,[
           'email'=>'required',
           'password'=>'required'
        ]);

        if(!Auth::attempt($request->only(['email','password']),$request->has('remember'))){
            return redirect()->back()->with('info','Wrong sign in information!');
        }
        Auth::user()->logInStat();
        return redirect()->route('home')->with('info','You are now signed in!');
    }

    public function getSignOut(){
        Auth::user()->logOutStat();
        Auth::logout();
        return redirect()->route('home')->with('info','Logged out');
    }
}
