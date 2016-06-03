<?php

namespace Chatter\Http\Controllers;

use Chatter\Gallery;
use Chatter\Image;
use Illuminate\Http\Request;

use Chatter\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function postUploadImage(Request $request){
        $file=$request->file('file');
        $filename=uniqid().$file->getClientOriginalName();
        $file->move(public_path().'/gallery/images',$filename);
        $galleryID=$request->input('gallery_id');
        $image=Image::create([
            'gallery_id'=>$galleryID,
            'file_name'=>$filename,
            'file_size'=>$file->getClientSize(),
            'file_mime'=>$file->getClientMimeType(),
            'file_path'=>'/gallery/images/'.$filename,
            'user_id'=>Auth::user()->id,
        ]);
        return $image;
    }
    public function getDeleteImage($id){
        $image=Image::where('id',$id)->where('user_id',Auth::user()->id)->get()->first();
        $image->delete();
        unlink(public_path().$image->file_path);
        return redirect()->back();
    }

    public function getSlideshow($galleryId,$picId){
        $images= Image::where('gallery_id',$galleryId)->where('user_id',Auth::user()->id)->get();
        if($images->first()==null){
            return redirect()->back()->with('info','The gallery you are trying to access does not exist or does not belong to you!');
        }
        $gallery=Gallery::find($galleryId);
        return view('gallery.slide')->with('images',$images)->with('picId',$picId)->with('gallery',$gallery);
    }
}
