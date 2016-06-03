<?php

namespace Chatter\Http\Controllers;

use Chatter\Status;
use Illuminate\Http\Request;

use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $statuses=Status::notReply()->where(function($query){
                return $query->where('user_id',Auth::user()->id)->orWhereIn('user_id',Auth::user()->friends()->lists('id'));
            })->orderBy('created_at','desc')->paginate(10);
            return view('timeline.index')->with('statuses',$statuses);
        }
        return view('home');
    }

    
}
