<?php

namespace Chatter\Http\Controllers;

use Chatter\Like;
use Chatter\Status;
use Chatter\User;
use Illuminate\Http\Request;
use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class StatusController extends Controller
{
    public function postStatus(Request $request){
        $this->validate($request,[
            'status'=>'required|max:1000'
        ]);
        $body=$request->input('status');
        //find a word starting with #
        $hashtag=$body;
        $final='';
        if(strpos($body,'#')!==false){
            //cut the sentance from begining of # til the end
            $final=substr($hashtag,strpos($body,'#'));
            $hashtag=substr($hashtag,strpos($body,'#')+1);
            //get the pos of first space
            $firstSpace=strpos($hashtag,' ');
            //cut to the first space
            $hashtag=substr($hashtag,$firstSpace);
        }
        //search from database
        $user=User::where('username',$hashtag)->get()->first();
        if($user){
            $href='localhost:8000/user/'.$user->username;
            $subject="<a href='$href'>$final</a>";
            $body=str_replace($final,$subject,$body);
        }

//        $file=$request->file('file');
//        $filename=uniqid().$file->getClientOriginalName();
//        $file->move(public_path().'/gallery/images',$filename);

        Auth::user()->statuses()->create([
            'body'=>$body,
//            'file_path'=>'/gallery/images/'.$filename,
//            'file_mime'=>$file->getClientMimeType(),
        ]);
        return redirect()->route('home')->with('info','Status Posted!');
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
        $body=$request->input('reply-'.$statusId);
        $hashtag=$body;
        $final='';
        if(strpos($body,'#')!==false){
            //cut the sentance from begining of # til the end
            $final=substr($hashtag,strpos($body,'#'));
            $hashtag=substr($hashtag,strpos($body,'#')+1);
            //get the pos of first space
            $firstSpace=strpos($hashtag,' ');
            //cut to the first space
            $hashtag=substr($hashtag,$firstSpace);
        }
        //search from database
        $user=User::where('username',$hashtag)->get()->first();
        if($user){

            $href='localhost:8000/user/'.$user->username;
            $subject="<a href='$href'>$final</a>";
            $body=str_replace($final,$subject,$body);
        }

//        $file=$request->file('file');
//        $filename=uniqid().$file->getClientOriginalName();
//        $file->move(public_path().'/gallery/images',$filename);

        $reply=Status::create([
            'body'=>$body,
//            'file_path'=>'/gallery/images/'.$filename,
//            'file_mime'=>$file->getClientMimeType(),
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->route('home');
    }

    public function getLike($statusId){
        $status=Status::find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendsWith($status->user)){
            return redirect()->route('home')->with('info','Not your friend!');
        }

        $like=Like::where('likeable_id',$statusId)->where('user_id',Auth::user()->id);

        if(Auth::user()->hasLikedStatus($status)){
            $like->delete();
        }else{
            $like=$status->likes()->create([]);
            $user=Auth::user();
            $user->likes()->save($like);
        }
        return redirect()->back();
    }

    public function postHashtagSearch(){
        $query=Input::get('query');

        $users=User::like('username',$query)->get();
        $finalUsers=[];
        foreach($users as $user){
            if($user->isFriendsWith(Auth::user())){
                array_push($finalUsers,$user);
            }
        }

        return $finalUsers;
    }
}
