@extends('templates.default')
@section('title')
    {{$gallery->name}}
@endsection
@section('content')
    <a  href="{{route('gallery.view',['id'=>$gallery->id])}}" class="btn btn-primary">Back</a>
    <div class="slider">
        @foreach($images as $image)
        <div class="slide">
            <img src="{{url($image->file_path)}}" alt="" class="image">
        </div>
        @endforeach
    </div>
    <div class="slider-nav">
        <div class="navigation-Buttons">
        <button class="arrow-prev"><img src="{{\Illuminate\Support\Facades\URL::to('src/imgs/arrow-prev.png')}}"></button>
        <button class="arrow-next"><img src="{{\Illuminate\Support\Facades\URL::to('src/imgs/arrow-next.png')}}"></button>
        </div>
        <ul class="slider-dots">
            <?php $counter=0;?>
            @foreach($images as $image)
                <li class="dot" value="{{$counter}}">
                    <img src="{{url($image->file_path)}}" alt="" class="the-img">
                    {{--<div class="back"></div>--}}
                </li>
                <?php $counter++;?>
            @endforeach
        </ul>

    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{URL::to('src/css/slideshow.css')}}" crossorigin="anonymous">
@endsection

@section('scripts')

<script>
    var picture="{{$picId}}";
    var currentImage=$('.slider').children().first();
    var currentDot=$('.slider-dots').children().first();
    var dots=$('.slider-dots').children();

    $(document).ready(function(){
        if(picture>0){
            while(picture!=0){
                var nextImage=currentImage.next();
                currentImage=nextImage;
                var nextDot=currentDot.next();
                currentDot=nextDot;
                picture--;
            }
        }
        currentImage.addClass('active-slide');
        currentDot.addClass('active-dot');
        $('.dot').click(function () {
            var pic=$(this).val();
            var curImage=$('.slider').children().first();
            var curDot=$('.slider-dots').children().first();
            if(pic>0){
                while(pic!=0){
                    var nexImage=curImage.next();
                    curImage=nexImage;
                    var nexDot=curDot.next();
                    curDot=nexDot;
                    pic--;
                }
            }
            $('.active-dot').removeClass('active-dot');
            $('.active-slide').removeClass('active-slide');
            curImage.addClass('active-slide');
            curDot.addClass('active-dot');
        });

        $('.arrow-prev').click(function () {
            var currentSlide = $('.active-slide');
            var prevSlide = currentSlide.prev();

            var currentDot = $('.active-dot');
            var prevDot = currentDot.prev();

            if(prevSlide.length === 0) {
                prevSlide = $('.slide').last();
                prevDot = $('.dot').last();
            }

            currentSlide.removeClass('active-slide');
            currentDot.removeClass('active-dot');
            prevSlide.addClass('active-slide');
            prevDot.addClass('active-dot');
        });
        var next=function () {
            var currentSlide = $('.active-slide');
            var nextSlide = currentSlide.next();

            var currentDot = $('.active-dot');
            var nextDot = currentDot.next();

            if(nextSlide.length === 0) {
                nextSlide = $('.slide').first();
                nextDot = $('.dot').first();
            }

            currentSlide.removeClass('active-slide');
            currentDot.removeClass('active-dot');

            nextSlide.addClass('active-slide');
            nextDot.addClass('active-dot');

        };
        $('.image').click(next);
        $('.arrow-next').click(next);


    });
</script>
@endsection