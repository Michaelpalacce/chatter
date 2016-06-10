<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table='gallery';

    public function user(){
        return $this->belongsTo('Chatter\User');
    }

    public function images(){
     return  $this->belongsTo('Chatter\Image');
    }
}
