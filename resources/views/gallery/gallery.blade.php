@extends('templates.default')

@section('title')
Gallery
@endsection

@section('content')
    <div class="col-md-4">
        <h1>Create New Gallery</h1>
        <form class="form" action="{{route('gallery.save')}}" method="post">
            <input type="hidden" name="_token" value="{{Session::token()}}">

            <div class="form-group {{$errors->has('gallery_name')?'has-error':''}}">
                <input type="text" name="gallery_name" placeholder="Name of the gallery" class="form-control" value="{{Request::old('gallery_name')}}">
                @if($errors->has('gallery_name'))
                    <span class="help-block">{{$errors->first('gallery_name')}}</span>
                @endif
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1>My galleries</h1>
        </div>

        @if($galleries->count()>0)
            @foreach($galleries as $gallery)

                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            {{--<img src="..." alt="...">--}}
                            <div class="caption">
                                <h3>{{$gallery->name}}</h3>
                                <span class="pull-right">
                                   <?php
                                        $images=\Chatter\Image::where('gallery_id',$gallery->id)->get();
                                        echo $images->count();
                                    ?>

                                </span>
                                <br/>
                                <p><a href="{{route('gallery.view',['id'=>$gallery->id])}}" class="btn btn-primary" role="button">View</a> <a href="{{route('gallery.delete',['id'=>$gallery->id])}}" class="btn btn-danger" role="button">Delete</a></p>
                            </div>
                        </div>
                    </div>

            @endforeach
        @endif
    </div>


    <script>
        $(document).ready(function(){

        });
    </script>
@endsection