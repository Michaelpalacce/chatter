@extends('templates.default')
@section('title')
    Conversations
@endsection
@section('content')
    <link rel="stylesheet" href="{{URL::to('src/css/messages.css')}}" crossorigin="anonymous">
    <div class="row">
        <div class="col-xs-6">
            <h3>Your Friends</h3>

            @if(!$friends->count())
                <p>You have no friends yet!</p>
            @else
                @foreach($friends as $user)
                    <div class="media">
                        <a class="pull-left" href="{{route('profile.index',['username'=>$user->username])}}">
                            <img class="media-object" alt="{{$user->getNameOrUsername()}}" src="{{$user->getAvatarUrl()}}">
                        </a>
                        @if($user->logged)
                            <span class="status-person-on pull-left">On</span>
                        @else
                            <span class="status-person-off pull-left">Off</span>
                        @endif
                        <div class="media-body">
                            <a class="btn btn-primary pull-right" href="{{route('messenger.conversation',['id'=>$user->id])}}">
                                <span>Conversation</span>
                            </a>
                            <h4 class="media-heading"><a href="{{route('profile.index',['username'=>$user->username])}}">{{$user->getNameOrUsername()}}</a></h4>
                            @if($user->location)
                                <p>{{$user->location}}</p>
                            @endif

                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection
{{--{{route('messenger.conversation',['username'=>$user->username])}}--}}