<?php

namespace Chatter\Http\Controllers;

use Chatter\Status;
use Chatter\User;
use Illuminate\Http\Request;
use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile($username){
        $user=User::where('username',$username)->first();
        if(!$user){
            abort(404);
        }
        $statuses= $user->statuses()->notReply()->get();
        return view('profile.index')->with('user',$user)->with('statuses',$statuses)->with('authUserIsFriend',Auth::user()->isFriendsWith($user));
    }

    public function getEdit(){
        return view('profile.edit');
    }

    public function postEdit(Request $request){
        $this->validate($request,[
            'first_name'=>'alpha|max:50',
            'last_name'=>'alpha|max:50',
            'location'=>'max:20',
        ]);

        Auth::user()->update([
           'first_name'=>$request->input('first_name'),
           'last_name'=>$request->input('last_name'),
           'location'=>$request->input('location'),
        ]);

        return redirect()->route('profile.edit')->with('info','Your profile has been updated!');
    }

    public function postReply(Request $request,$statusId){
        $this->validate($request,[
            "reply-$statusId"=>'required|max:1000'
        ],['required'=>'The reply body is required']);

        $status=Status::notReply()->find($statusId);
        if(!$status){
            return redirect()->route('home')->with('info','Not a valid post!');
        }

        if(!Auth::user()->isFriendsWith($status->user)&&Auth::user()->id!==$status->user->id){
            return redirect()->route('home');
        }
        $reply=Status::create([
            'body'=>$request->input('reply-'.$statusId)
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->route('profile.index',['username'=>Auth::user()->username]);
    }
}

