<?php

namespace Chatter\Http\Controllers;

use Chatter\Chat;
use Chatter\Message;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MessageController extends Controller
{
    public function getChatters(){
        $friends=Auth::user()->friends();
        return view('messages.index')->with('friends',$friends);
    }


    public function getConversation($id){
        $chat=Chat::where(function ($query)  use($id){
            $query->where('userOne', '=', $id)
                ->orWhere('userTwo', '=', $id);
        })->where(function ($query){
            $query->where('userOne', '=',Auth::user()->id )
                ->orWhere('userTwo', '=',Auth::user()->id);
        })->get();

        $check=(array)$chat;

        if(!array_filter($check)){

            $chat= new Chat();
            $chat->userOne=Auth::user()->id;
            $chat->userTwo=$id;
            $chat->save();
        }

        $user=User::find($id);
        $username=$user->username;
        $ch=$chat[0];

        return view('messages.conversation')->with('id',$id)->with('chat',$ch)->with('username',$username);
    }

    public function sendMessage(){
        $username=Input::get('username');
        $text=Input::get('text');
        $chatId=Input::get('chatId');


        $chatMessage= new Message();
        $chatMessage->sender_username=$username;
        $chatMessage->message=$text;
        $chatMessage->chat_id=$chatId;
        $chatMessage->save();
    }

    public function postIsTyping(){
        $userId=Input::get('userId');
        $chatId=Input::get('chatId');

        $chat=Chat::find($chatId);

        if($chat->userOne==$userId){
            $chat->user1_is_typing=true;
        }
        else{
            $chat->user2_is_typing=true;
        }
        $chat->save();

    }

    public function postNotTyping(){
        $userId=Input::get('userId');
        $chatId=Input::get('chatId');

        $chat=Chat::find($chatId);

        if($chat->userOne==$userId){
            $chat->user1_is_typing=false;
        }
        else{
            $chat->user2_is_typing=false;
        }
        $chat->save();

    }

    public function postRetrieve(){
        $username=Input::get('username');
        $chatId=Input::get('chatId');
        $message=Message::where('sender_username','!=',$username)->where('chat_id',$chatId)->where('read','=',0)->first();
        if(count($message)>0){
            $message->read='1';
            $message->save();
            return $message->message;
        }
    }

    public function postTyping(){
        $userId=Input::get('userId');
        $chatId=Input::get('chatId');
        $chat=Chat::find($chatId);
        dd($chat);
        if($chat->userOne==$userId){
            if($chat->user2_is_typing){
                $userTwo=User::find($chat->userTwo);
                return $userTwo->username;
            }
        }
        else{
            if($chat->user1_is_typing){
                $userOne=User::find($chat->userOne);
                return $userOne->username;
            }
        }
    }

}
