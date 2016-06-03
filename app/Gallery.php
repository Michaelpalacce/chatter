<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table='gallery';

    public function user(){
        $this->belongsTo('Chatter\User');
    }

    public function images(){
       $this->belongsTo('Chatter\Image');
    }
}
