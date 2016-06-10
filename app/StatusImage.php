<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class StatusImage extends Model
{
    protected $table='status_images';

    protected $fillable=[
        'user_id','file_mime','file_size','file_path','status_id'
    ];
    public function status(){
        return $this->belongsTo('Chatter\Status');
    }
}
