<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected  $table='statuses';

    protected $fillable=[
        'body'
    ];

    public function user(){
        return $this->belongsTo('Chatter\User','user_id');
    }

    public function scopeNotReply($query){
        return $query->whereNull('parent_id');
    }

    public function replies(){
        return $this->hasMany('Chatter\Status','parent_id');
    }

    public function likes(){
        return $this->morphMany('Chatter\Like','likeable');
    }
    public function image(){
        return $this->hasOne('Chatter\StatusImage');
    }
}
