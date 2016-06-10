<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table='to_dos';

    protected $fillable=['body','user_id'];

    public function user(){
        $this->belongsTo('Chatter\User');
    }
}
