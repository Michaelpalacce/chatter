@extends('templates.default')
@section('title')
    Timeline
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{route('status.post')}}" method="post">
                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                    <textarea placeholder="What's up {{Auth::user()->getNameOrUserName()}}?" name="status" id="status" class="form-control" rows="2"></textarea>
                </div>
                @if($errors->has('status'))
                    <span class="help-block">{{$errors->first('status')}}</span>
                @endif
                <img src="" alt="" style="display: none; width: 200px; height: 200px; margin-bottom: 10px;" id="img">
                <div class="wrapp" style=" margin-bottom: 10px;">
                    <label class="btn btn-default btn-file">
                        Image <input type="file" style="display: none;" id="upload" name="file">
                    </label>
                </div>

                <button type="submit" class="btn btn-default">Update status</button>
                <input type="hidden" name="_token" value="{{Session::token()}}">
            </form>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            @if(!$statuses->count())
                <p>It`s a bit empty in here!</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <a class="pull-left" href="{{route('profile.index',['username'=>$status->user->username])}}">
                            <img class="media-object" alt="{{$status->user->getNameOrUsername()}}" src="{{$status->user->getAvatarUrl()}}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{route('profile.index',['username'=>$status->user->username])}}">{{$status->user->getNameOrUsername()}}</a></h4>
                            <span>{!!$status->body!!}</span>
                            <ul class="list-inline">
                                <li>{{$status->created_at->diffForHumans()}}</li>
                                @if($status->user->id!==Auth::user()->id)
                                    <li><a href="{{route('status.like',['statusId'=>$status->id])}}" class="btn btn-primary">Like</a></li>
                                @endif
                                <li>{{$status->likes()->count()}}  {{str_plural('like',$status->likes()->count())}}</li>
                            </ul>
                            @foreach($status->replies as $reply)
                                <div class="comment">
                                    <a class="pull-left" href="{{route('profile.index',['username'=>$reply->user->username])}}">
                                        <img class="media-object" alt="{{$reply->user->getNameOrUsername()}}" src="{{$reply->user->getAvatarUrl()}}">
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{route('profile.index',['username'=>$reply->user->username])}}">{{$reply->user->getNameOrUsername()}}</a></h5>
                                        <span>{!!$reply->body!!}</span>
                                        <ul class="list-inline">
                                            <li>{{$reply->created_at->diffForHumans()}}</li>
                                            @if($reply->user->id!==Auth::user()->id)
                                                <li><a href="{{route('status.like',['statusId'=>$reply->id])}}" class="btn btn-primary">Like</a></li>
                                            @endif
                                            <li>{{$reply->likes()->count()}} {{str_plural('like',$reply->likes()->count())}}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            <form role="form" action="{{route('status.reply',['statusId'=>$status->id])}}" method="post">
                                <div class="form-group {{$errors->has('reply-'.$status->id)?'has-error':''}}">
                                    <textarea name="reply-{{$status->id}}" class="form-control replier" rows="2" placeholder="Reply to this status"></textarea>
                                    @if($errors->has('reply-'.$status->id))
                                        <span class="help-block">{{$errors->first('reply-'.$status->id)}}</span>
                                    @endif

                                </div>
                                <input type="submit" value="Reply" class="btn btn-default btn-sm">
                                <input type="hidden" name="_token" value="{{Session::token()}}">
                            </form>
                        </div>
                    </div>
                @endforeach
                {!! $statuses->render() !!}
            @endif
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

    <object width="425" height="350" data="http://www.youtube.com/v/Ahg6qcgoay4" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/Ahg6qcgoay4" /></object>

@endsection
@section('scripts')
    <script>
        var hashtagUrl="{{route('hashtag.search')}}";
        var token="{{Session::token()}}";
        var btnToCLick=document.getElementById('upload');

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                $('#img').show();
                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#upload").change(function(){
            readURL(this);
        });
    </script>
@endsection