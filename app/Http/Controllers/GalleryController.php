<?php

namespace Chatter\Http\Controllers;

use Chatter\Gallery;
use Chatter\Image;
use Illuminate\Http\Request;
use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\Flysystem\Exception;


class GalleryController extends Controller
{



    public function getList(){
        $user_id=Auth::user()->id;
        $galleries=Gallery::where('user_id',$user_id)->get();

        return view('gallery.gallery')->with('galleries',$galleries);
    }

    public function postSave(Request $request){
        $this->validate($request,[
            'gallery_name'=>'required|max:50|min:3'
        ]);

        $gallery=new Gallery();
        $gallery->name=$request->input('gallery_name');
        $gallery->user_id=Auth::user()->id;
        $gallery->published=1;
        $gallery->save();

        return redirect()->back();
    }

    public function getGallery($id){
        $gallery=Gallery::find($id);
        $user_id=Auth::user()->id;
        if($gallery==null||$gallery->user_id!=$user_id){
            return redirect()->back();
        }
        $images=$this->getAllImages($id);
        return view('gallery.view')->with('gallery',$gallery)->with('images',$images);
    }

    public function getAllImages($galleryId){
        $images=Image::where('gallery_id',$galleryId)->get();
        return $images;
    }

    public function postDeleteGallery($id){
        $gallery=Gallery::where('id',$id)->where('user_id',Auth::user()->id)->get()->first();

        $gallery->delete();
        $images=Image::where('gallery_id',$id)->get();

        foreach($images as $image){
            $image->delete();
            unlink(public_path().$image->file_path);
        }
        return redirect()->back();
    }
}
