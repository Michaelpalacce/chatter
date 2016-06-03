<?php

namespace Chatter\Http\Controllers;

use Chatter\User;
use Illuminate\Http\Request;
use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function getResults(Request $request){

        $query=$request->input('query');

        if(!$query){
            $users2=User::where('id','!=',Auth::user()->id)->get();
            return view('search.results')->with('users',$users2);
        }

        $users= User::where(DB::raw("CONCAT(first_name, ' ', last_name)"),'LIKE',"%{$query}%")->orWhere('username','LIKE',"%{$query}$")->get();

        return view('search.results')->with('users',$users);
    }

}
