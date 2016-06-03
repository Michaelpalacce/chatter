@extends('templates.default')
@section('title')
    {{$username}}
@endsection
@section('content')
    <link rel="stylesheet" href="{{URL::to('src/css/messages.css')}}" crossorigin="anonymous">
    <div class="col-lg-6 col-lg-offset-3">
        <h1 class="greetings">Hello, <span id="username">{{$username}}</span></h1>
        <div id="chat-window" class="col-lg-12">

        </div>
        <div class="col-lg-12">
            <div class="col-lg-12" id="typingStatus" style="padding: 15px;" ></div>
            <input type="text" id="text" class="form-control col-lg-12" autofocus="" >
            {{--onblur="notTyping()"--}}
        </div>


    </div>

    <script>
        var selfUsername='{{Auth::user()->username}}';
        var sendUrl='{{ route('messenger.send') }}';
        var notTypingUrl='{{route('messenger.notTyping')}}';
        var isTypingUrl='{{route('messenger.isTyping')}}';
        var retrieveUrl='{{route('messenger.retrieve')}}';
        var retrieveTypingUrl='{{route('messenger.typing')}}';
        var chatId='{{$chat->id}}';
        var userId='{{$id}}';
        var token='{{Session::token()}}'
    </script>
    <script src="{{URL::to('src/js/messages.js')}}"></script>
@endsection

