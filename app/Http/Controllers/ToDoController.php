<?php

namespace Chatter\Http\Controllers;

use Chatter\ToDo;
use Illuminate\Http\Request;

use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ToDoController extends Controller
{
    public function getToDos(){
        $todos=ToDo::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('todo.index')->with('todos',$todos);
    }

    public function postNewToDo(Request $request){
        $this->validate($request,[
            'body'=>'required'
        ]);

        ToDo::create(['body'=>$request->input('body'),
            'user_id'=>Auth::user()->id,
            'done'=>false
        ]);

        return redirect()->back()->with("todos",ToDo::where('user_id',Auth::user()->id)->get());
    }
    public function postComplete(){
        $body= Input::get('body');

        $todo=ToDo::where('user_id',Auth::user()->id)->where('body',$body)->get()->first();
        $todo->delete();
    }
}
