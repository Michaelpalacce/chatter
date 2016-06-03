@extends('templates.default')

@section('content')
    <div class="slider">
        @foreach($images as $image)
        <div class="slide">
            <div class="container">
                <img src="{{url($image->file_path)}}" alt="" class="image">
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{URL::to('src/css/slideshow.css')}}" crossorigin="anonymous">
@endsection