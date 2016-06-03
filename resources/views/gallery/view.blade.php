@extends('templates.default')

@section('title')
    {{$gallery->name}}
@endsection

@section('content')
    <style>
        #gallery-images img{
            width:240px;
            height:160px;
            border:1px solid black;
            margin-bottom:10px;
        }
        #gallery-images ul{
            margin:0;
            padding:0;
        }
        #gallery-images li{
            margin:0;
            padding:0;
            list-style-type: none;
            float: left;
            padding-right: 10px;
        }
        .imgWrap {
            position: relative;

        }
        .delBut{
            margin-left:35%;
            margin-bottom:5px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <h1>{{$gallery->name}}</h1>
        </div>
    </div>
   <div class="row">
       <div class="col-md-12">
           <div id="gallery-images">
               <ul>
                   @foreach($images as $image)
                       <li>
                           <a href="{{route('image.delete',['id'=>$image->id])}}" class="btn btn-danger delBut" value="{{$image->id}}">Delete</a>
                           <div class="imgWrap">
                               <img src="{{url($image->file_path)}}" alt="">
                           </div>
                       </li>
                   @endforeach
               </ul>
           </div>
       </div>
   </div>

    <div class="row">
        <div class="col-md-12">
            <form action="{{route('image.upload')}}" class="dropzone" id="addImages" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{Session::token()}}">
                <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="{{route('gallery.list')}}" class="btn btn-primary">Back</a>
        </div>
    </div>
    <script>
        var publicPath="{{public_path()}}";
        var token="{{Session::token()}}";
    </script>
@endsection