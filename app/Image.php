<?php

namespace Chatter;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table='images';

    protected $fillable=['gallery_id','file_name','file_size','file_mime','file_path','user_id'];

    public function gallery(){
       return $this->belongsTo('Chatter\Gallery');
    }

    public function getGallery($id){
        return Gallery::where("id",$id)->get();
    }
}
