<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table='chats';

    public function messages()
    {
        return $this->hasMany('Chatter\Message');
    }

    public function getMessages(){
        return Message::where('chat_id',$this->id)->get();
    }
}
