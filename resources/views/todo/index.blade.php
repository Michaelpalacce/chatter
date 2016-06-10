@extends('templates.default')
@section('style')
    <style>
        .todos{
            margin:0 auto;
            width:50%;
            box-shadow: 1px 4px 2px grey;
            box-radius: 4px;
            display: block;
            text-align: center;
            background: #E6E6E6;
        }
        .todos .todo{
            margin:20px auto;
            width:50%;
        }

        .new-todo input[type='text']{
            border:0px;
            border-bottom:1px solid grey;
            -webkit-border-radius:2px;
            -moz-border-radius:2px;
            border-radius:2px;
        }

    </style>
@endsection
@section('content')
    <div class="new-todo">
        <form action="{{route('todo.index')}}" method="post">
            <input type="text" name="body" placeholder="New Todo">
            <input type="submit" value="Create">
            <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>
    </div>
<div class="todos">
    <hr>
    @foreach($todos as $todo)
        <div class="todo">
            <p>{{$todo->body}}</p>
            <hr>
        </div>

    @endforeach
</div>
@endsection

@section('scripts')
<script>
    var token="{{Session::token()}}";
    var completeRoute="{{route('todo.complete')}}";
    $(document).ready(function(){
        $('.todo').on('click',function () {
            var text=$(this).children().text();
            $(this).animate({height:'toggle'},'fast');
            $.ajax({
                url:completeRoute,
                type:'POST',
                data:{body:text,_token:token}
            }).done(function(){
            });
        });
    });
</script>
@endsection