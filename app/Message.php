<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table='messages';

    public function chat(){
        $this->belongsTo('Chatter\Chat','chat_id');
    }
}
